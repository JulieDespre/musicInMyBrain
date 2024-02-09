DROP TABLE IF EXISTS "partie";
DROP SEQUENCE IF EXISTS partie_id_seq;
CREATE SEQUENCE partie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."partie"
(
    "id"            text DEFAULT 'nextval(''partie_id_seq'')' NOT NULL,
    "user_email"    character(255)                            NOT NULL,
    "score"         integer                                   NOT NULL,
    "difficulte"    integer                                   NOT NULL,
    "serie_id"      integer                                   NOT NULL,
    "user_username" character(255)                            NOT NULL,
    CONSTRAINT "partie_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "partie_cache";
DROP SEQUENCE IF EXISTS partie_cache_id_seq;
CREATE SEQUENCE partie_cache_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."partie_cache" (
                                         "id" text DEFAULT 'nextval(''partie_cache_id_seq'')' NOT NULL,
                                         "user_email" text NOT NULL,
                                         "serie_id" integer NOT NULL,
                                         "temps" integer NOT NULL,
                                         "distance" integer NOT NULL,
                                         "user_username" text NOT NULL,
                                         "tours" integer NOT NULL,
                                         "difficulte" integer NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "partie_schema";
DROP SEQUENCE IF EXISTS partie_schema_id_seq;
CREATE SEQUENCE partie_schema_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."partie_schema"
(
    "id"              integer DEFAULT nextval('partie_schema_id_seq') NOT NULL,
    "partie_id"       text                                            NOT NULL,
    "tours"           integer                                         NOT NULL,
    "localisation_id" integer                                         NOT NULL,
    CONSTRAINT "partie_schema_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "partie" ("id", "user_email", "score", "difficulte", "serie_id", "user_username")
VALUES ('4782d7be-b6df-4132-9f34-2a2be5e15a68',
        'AlixPerrot@free.fr',
        200, 1, 1,
        'AlixPerrot'),
       ('ef671181-ec19-4239-8bbb-24a090e696b1',
        'AlixPerrot@free.fr',
        120, 1, 1,
        'AlixPerrot');

INSERT INTO "partie_schema" ("id", "partie_id", "tours", "localisation_id")
VALUES (0, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 1, 4),
       (1, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 2, 1),
       (2, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 3, 11),
       (3, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 4, 7),
       (4, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 5, 5),
       (5, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 6, 3),
       (6, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 7, 8),
       (7, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 8, 12),
       (8, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 9, 9),
       (9, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 10, 2),
       (10, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 11, 6),
       (11, '4782d7be-b6df-4132-9f34-2a2be5e15a68', 12, 10),
       (12, 'ef671181-ec19-4239-8bbb-24a090e696b1', 1, 9),
       (13, 'ef671181-ec19-4239-8bbb-24a090e696b1', 2, 1),
       (14, 'ef671181-ec19-4239-8bbb-24a090e696b1', 3, 5),
       (15, 'ef671181-ec19-4239-8bbb-24a090e696b1', 4, 11),
       (16, 'ef671181-ec19-4239-8bbb-24a090e696b1', 5, 10),
       (17, 'ef671181-ec19-4239-8bbb-24a090e696b1', 6, 4),
       (18, 'ef671181-ec19-4239-8bbb-24a090e696b1', 7, 8),
       (19, 'ef671181-ec19-4239-8bbb-24a090e696b1', 8, 2),
       (20, 'ef671181-ec19-4239-8bbb-24a090e696b1', 9, 3),
       (21, 'ef671181-ec19-4239-8bbb-24a090e696b1', 10, 6),
       (22, 'ef671181-ec19-4239-8bbb-24a090e696b1', 11, 7),
       (23, 'ef671181-ec19-4239-8bbb-24a090e696b1', 12, 12);