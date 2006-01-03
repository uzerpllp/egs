CREATE SEQUENCE DOCTYPE_ID_SEQ
  START WITH 1
  NOMAXVALUE
  MINVALUE 1
  NOCYCLE
  NOCACHE
  NOORDER;


CREATE SEQUENCE DOCFIELDS_ID_SEQ
  START WITH 1
  NOMAXVALUE
  MINVALUE 1
  NOCYCLE
  NOCACHE
  NOORDER;


CREATE SEQUENCE DOCFIELDVALUES_ID_SEQ
  START WITH 1
  NOMAXVALUE
  MINVALUE 1
  NOCYCLE
  NOCACHE
  NOORDER;




  CREATE TABLE docfieldslabel (
  doc_field_id number(4) NOT NULL,
  field_label char(80) NOT NULL,
  locale char(80) NOT NULL );

   aLTER TABLE DOCFIELDSLABEL ADD (
  PRIMARY KEY (doc_field_id)
    USING INDEX);


  CREATE TABLE doctype (
     doc_type_id number(4) not null,
     doc_type_name char(255) not null,
     primary key (doc_type_id));



     CREATE TABLE docfields (
         id number(4) not null,
         doc_type_id number(4) not null ,
         field_name char(80) not null,
         field_position number(4) not null,
         field_type char(80) not null,
         field_values char(80) not null,
         field_size number(38) not null,
         searchable number(4) not null,
         required number(4) not null,
         primary key (id)
 );

 CREATE TABLE docfieldvalues (
         id number(4) not null,
         file_id number(4) not null ,
         field_name char(80) not null,
         field_value char(80) not null,
         primary key (id)
 );

 alter table files add (doctype number(4));

 CREATE OR REPLACE TRIGGER DOCTYPE_ID_TRIGGER
  BEFORE INSERT ON DOCTYPE
  REFERENCING NEW AS NEW OLD AS OLD
  FOR EACH ROW
BEGIN
  SELECT doctype_ID_SEQ.NEXTVAL INTO :NEW.doc_type_id FROM DUAL;
END;
/
show errors;

CREATE OR REPLACE TRIGGER DOCFIELDS_ID_TRIGGER
  BEFORE INSERT ON DOCFIELDS
  REFERENCING NEW AS NEW OLD AS OLD
  FOR EACH ROW
BEGIN
  SELECT docfields_ID_SEQ.NEXTVAL INTO :NEW.id FROM DUAL;
END;
/
show errors;

CREATE OR REPLACE TRIGGER DOCFIELDVALUES_ID_TRIGGER
  BEFORE INSERT ON DOCFIELDVALUES
  REFERENCING NEW AS NEW OLD AS OLD
  FOR EACH ROW
BEGIN
  SELECT docfieldvalues_ID_SEQ.NEXTVAL INTO :NEW.id FROM DUAL;
END;
/
show errors;


     INSERT INTO doctype (doc_type_name) values ('Default');
