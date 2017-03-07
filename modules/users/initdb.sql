INSERT INTO `users`
(
    `id`,
    `email`,
    `password` ,
    `status` ,
    `usertype` ,
    `created`,
    `updated`
)

VALUES
    (1, 'admin','987', 'registred', 'employe', NOW(), NOW()),
    (2, 'skillstester','987', 'registred', 'employe', NOW(), NOW()),
    (3, 'rh-tester','987', 'registred', 'recruiter', NOW(), NOW())
    (4, 'user', '987', 'registred', 'recruiter', NOW(), NOW())
;
