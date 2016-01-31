CREATE TYPE male_female AS ENUM ('male', 'female');

CREATE TABLE students
(
  id serial NOT NULL,
  first_name character varying(200),
  last_name character varying(200),
  student_group character varying(5),
  mark integer,
  email character varying(254),
  gender male_female,
  auth_code character varying(32),
  birthyear integer,
  CONSTRAINT students_pkey PRIMARY KEY (id),
  CONSTRAINT students_email_key UNIQUE (email),
  CONSTRAINT students_birthyear_check CHECK (birthyear >= 1900 AND birthyear <= 2000),
  CONSTRAINT students_mark_check CHECK (mark >= 0 AND mark <= 300)
)
WITH (
  OIDS=FALSE
);
