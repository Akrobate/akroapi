INSERT INTO `users`
(
    `id`,
    `email`,
    `login`,
    `password` ,
    `status` ,
    `created`,
    `updated`
)
VALUES
    (1, '', 'admin', '987', 'registred', NOW(), NOW()),
    (2, '', 'skillstester', '987', 'registred', NOW(), NOW()),
    (3, '', 'rh-tester', '987', 'registred', NOW(), NOW()),
    (4, '', 'user4', '987', 'registred', NOW(), NOW()),
    (5, '', 'user5', '987', 'registred', NOW(), NOW())
;
