SET NAMES utf8;
SET
time_zone = '+00:00';
SET
foreign_key_checks = 0;
SET
sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `users` (`email`, `password`, `active`, `activation_token`, `activation_token_expiration_date`,
                     `refresh_token`, `refresh_token_expiration_date`, `username`)
VALUES ('AlixPerrot@free.fr', '$2y$10$3irjl.hOiQp5QAyTOAINpe7FfabDvIDmuVCOZ49dHM7rdDY1jQiCC', 0, NULL, NULL,
        'ac590b521c41d3d4dd0c901b040d1b6317817b693a7b830b5f1d1e010e411a9a', '2023-09-29 09:12:52', 'AlixPerrot'),
       ('AlphonseFleury@sfr.fr', '$2y$10$0d2eTE0uQq9B8cJNy7jcIeoj1VqQa6aUzFsj0TDVC4BR.0VWn1wJK', 0, NULL, NULL, NULL,
        NULL, 'AlphonseFleury'),
       ('ArnaudeLeblanc@hotmail.fr', '$2y$10$FQkz7Li8ajyZYnpz9x8wLODQg1FTP9FKW88MrvjCC.XPgbcrHMkji', 0, NULL, NULL,
        NULL, NULL, 'ArnaudeLeblanc'),
       ('BertrandMallet@orange.fr', '$2y$10$94/.33E4qQBxuPXKIbg1rO59s/0zwyakQ15zqiPvAb/gxRK2HwKC.', 0, NULL, NULL, NULL,
        NULL, 'BertrandMallet'),
       ('BrigitteRenard@sfr.fr', '$2y$10$hu7oRms9tQ0ynKCQUFFbeOT8EmaaqFFXIZtI9Mgz0rf9UAciBOzsO', 0, NULL, NULL, NULL,
        NULL, 'BrigitteRenard')