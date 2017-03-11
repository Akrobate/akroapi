INSERT INTO `acl` (
`id_group`,
`access` ,
`module` ,
`action` ,
`created`
)
VALUES
(0,'public', 'users', 'login', NOW()),
(0,'public', 'users', 'suscribe', NOW()),
(0,'public', 'users', 'access', NOW()),
(0,'public', 'users', 'logout', NOW()),
(0,'public', 'users', 'add', NOW()),

(1, 'granted', 'users', 'myself', NOW()),
(1, 'granted', 'users', 'index', NOW()),

(1,'granted', 'users', 'getinfos', NOW()),
(1,'granted', 'users', 'setinfos', NOW()),


(1,'granted', 'testitem', 'save', NOW()),
(1,'granted', 'testitem', 'index', NOW()),
(1,'granted', 'testitem', 'edit', NOW()),
(1,'granted', 'testitem', 'delete', NOW()),
(1,'granted', 'testitem', 'view', NOW()),


(2,'granted', 'testitemrestricted', 'save', NOW()),
(2,'granted', 'testitemrestricted', 'index', NOW()),
(2,'granted', 'testitemrestricted', 'edit', NOW()),
(2,'granted', 'testitemrestricted', 'delete', NOW()),
(2,'granted', 'testitemrestricted', 'view', NOW())
;
