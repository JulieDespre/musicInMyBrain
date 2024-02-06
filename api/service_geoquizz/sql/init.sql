-- Adminer 4.8.1 PostgreSQL 15.4 (Debian 15.4-1.pgdg120+1) dump

DROP TABLE IF EXISTS "partie";
DROP SEQUENCE IF EXISTS partie_id_seq;
CREATE SEQUENCE partie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."partie" (
                                   "id" integer DEFAULT nextval('partie_id_seq') NOT NULL,
                                   "user_email" character(255) NOT NULL,
                                   "score" integer NOT NULL,
                                   "difficulte" integer NOT NULL,
                                   "serie_id" integer NOT NULL,
                                   "user_username" character(255) NOT NULL,
                                   CONSTRAINT "partie_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "partie_cache";
DROP SEQUENCE IF EXISTS partie_cache_id_seq;
CREATE SEQUENCE partie_cache_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."partie_cache" (
                                         "id" character(255) DEFAULT 'nextval(''partie_cache_id_seq'')' NOT NULL,
                                         "user_email" character(255) NOT NULL,
                                         "serie_id" integer NOT NULL,
                                         "temps" integer NOT NULL,
                                         "distance" integer NOT NULL,
                                         "user_username" character(255) NOT NULL,
                                         "tours" integer NOT NULL
) WITH (oids = false);


-- 2024-02-06 15:20:38.36416+00