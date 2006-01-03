<?php
/* $Id: mail.class.php 2 2004-08-05 21:42:03Z eroberts $ */
/**
 * Mailer class used to parse incoming mail and send mail
 */
class MAILER {
  // Variables for mail parsing
  var $rawdata;
  var $headers = array();
  var $mime_parts = array();
  var $body;

  // Variables for mail sending
  var $subject;
  var $message;
  var $to;
  var $email_from;
  var $send_headers;

  /**
   * Initialize parser and decode rawdata
   *
   * @param string $rawdata Raw email message
   */
  function MAILER($rawdata = null)
  {
    // If rawdata was given here then just start the decode
    if (!is_null($rawdata)) {
      $this->decode($rawdata);
    }
  }

  /**
   * Used to set various class variables
   *
   * @param string $var Class variable to be set
   * @param mixed $val Value to assign to the class variable
   * @return nothing
   */
  function set($var,$val)
  {
    $this->$var = $val;
  }

  /**
   * Retrieve the value of the specified variable
   *
   * @param string $var Variable to retrieve
   * @return string
   */
  function get($var)
  {
    return $this->$var;
  }

  /**
   * Takes the rawdata of an email and seperates headers from body
   * and assigns the correct values to the header variables
   *
   * @param string $rawdata Raw email message
   */
  function decode($rawdata)
  {
    // Parse headers and return whats left
    $leftover = $this->parse_headers($rawdata); 
    
    // If we received a mime mail then parse the mime parts
    if (!empty($this->headers['mime_boundary'])) {
      $leftover = str_replace("--".$this->headers['mime_boundary']."--","",$leftover);
      $parts = split("--".$this->headers['mime_boundary']."\n",$leftover);
      $num_parts = count($parts);
      
      for ($x = 1;$x < $num_parts;$x++) {
        $this->parse_mime($parts[$x]);
      }

      if (count($this->mime_parts) > 0) {
        foreach ($this->mime_parts as $mime) {
          // If the mime session was quote-printable then just
          // add it to the message body
          if (ereg("text/plain",$mime['content-type'])) {
            $this->body .= $mime['body']."\n";
          }
        }
      }
    } else {
      // If it wasn't a mime mail then whatever was left
      // we will just assume was the body of the mail
      $this->body = $leftover;
    }   
  }

  /**
   * Take the headers and retrieve the ones we want
   *
   * @param string $rawdata Raw email
   * @return string
   */
  function parse_headers($rawdata)
  {
    // If we didn't get any data to parse just stop now
    if (empty($rawdata)) {
      return;
    }
    
    $lines = split("\n",$rawdata);
    $headers = TRUE;
    $leftovers = "";

    foreach ($lines as $line) {
      // Assume the first blank we come across is the end
      // of the mail headers and start of the body
      if ((ereg("^\n$",$line) or empty($line))
      and $headers === TRUE) {
        $headers = FALSE;
        continue;
      }

      $line = trim($line);
      
      if ($headers === TRUE) {
        if (eregi("^boundary",$line)) {
          $parts = split("boundary=",$line);
          $boundary = str_replace("\"","",$parts[1]);
          $this->headers['mime_boundary'] = $boundary;
        } else {
          $parts = split(":",$line);
          if (count($parts) > 2) {
            $header = array_shift($parts);
            $this->headers[trim(strtolower($header))] = trim(implode(":",$parts));
          } else {
            $this->headers[trim(strtolower($parts[0]))] = trim($parts[1]);
          }
        }
      } else {
        $leftovers .= $line."\n";
      }
    }

    // Make sure the from address is just an address and not
    // a name with address
    if (ereg("<",$this->headers['from'])) {
      $parts = split("<",$this->headers['from']);
      $this->headers['from'] = str_replace(">","",$parts[1]);
    }

    // If we had multiple "To" addresses, seperate into an
    // array and make sure that we convert any addresses
    // that included a name into just the email address
    if (ereg(",",$this->headers['to'])) {
      $recipients = split(",",$this->headers['to']);
      $this->headers['to'] = array();
      
      foreach ($recipients as $recipient) {
        if (ereg("<",$recipient)) {
          $parts = split("<",$recipient);
          array_push($this->headers['to'],trim(str_replace(">","",$parts[1])));
        } else {
          array_push($this->headers['to'],trim($recipient));
        }
      }
    } else if (ereg("<",$this->headers['to'])) {
      $parts = split("<",$this->headers['to']);
      $this->headers['to'] = str_replace(">","",$parts[1]);
    } 

    return $leftovers;
  }

  /**
   * Parse mime sections and return array
   *
   * @param string $data
   * @return array
   */
  function parse_mime($data)
  {
    if (empty($data)) {
      return array();
    }
    
    trim($data);
    
    $lines = split("\n",$data);
    $headers = TRUE;
    $mime = array();

    $mime['body'] = '';
    $mime['content-disposition'] = '';

    foreach ($lines as $line) {
      if (($line == "\n" or empty($line)) 
      and $headers === TRUE) {
        $headers = FALSE;
        continue;
      }

      $line = trim($line);

      if ($headers) {
        if (eregi("^(charset|filename|name)",$line)) {
          $parts = split("=",$line);
          $mime[$parts[0]] = str_replace("\"","",$parts[1]);
        } else {
          $parts = split(":",$line);
          $mime[strtolower(trim($parts[0]))] = trim($parts[1]);
        }
      } else {
        $mime['body'] .= $line."\n";
      }
    }

    if (ereg("filename",$mime['content-disposition'])) {
      preg_match('/filename="([0-9a-z\.\-\_]+)"/i',$mime['content-disposition'],$filename);
      $mime['filename'] = $filename[1];
    }  

    if ($mime['content-transfer-encoding'] == "quoted-printable") {
      $mime['body'] = trim(quoted_printable_decode($mime['body']));
    } else {
      $mime['body'] = trim($mime['body']);
    }
      
    $this->mime_parts[] = $mime;
  }

  /**
   * Set the subject for sending messages
   *
   * @param string $subject
   */
  function subject($subject)
  {
    $this->subject = $subject;
  }

  /**
   * Set the address(es) to send mail to
   *
   * @param string|array $to
   */
  function to($to)
  {
    $this->to = $to;
  }

  /**
   * Set the message to send
   *
   * @param string $message
   */
  function message($msg)
  {
    $this->message = $msg;
  }

  /**
   * Add to send headers
   *
   * @param string $header
   */
  function add_header($header)
  {
    $this->send_headers .= ereg("\n",$header) ? $header : $header."\n";
  }

  /**
   * Send email message
   */
  function send()
  {
    if (!empty($this->email_from)) {
      $headers  = "From: ".$this->email_from."\n";
    }
    $headers .= $this->send_headers;
    
    if (is_array($this->to)) {
      foreach ($this->to as $email) {
        if (eregi("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$",$email)) {
          if ($_SESSION['debugger'] == "on") {
            $message = $this->message."\n\nEmail:$email\n";
            mail(_ADMINEMAIL_,$this->subject,$message,$headers);
          } else {
            mail($email,$this->subject,$this->message,$headers);
          }
        }
      }
    } else {
      if ($_SESSION['debugger'] == "on") {
        $message = $this->message."\n\nEmail: {$this->to}\n";
        mail(_ADMINEMAIL_,$this->subject,$message,$headers);
      } else {
        mail($this->to,$this->subject,$this->message,$headers);
      }
    }

    $this->to = "";
    $this->send_headers = "";
    $this->message = "";
    $this->subject = "";
  }
}	
?>
