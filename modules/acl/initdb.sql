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

(1,'granted', 'users', 'getskills', NOW()),
(1,'granted', 'users', 'addskill', NOW()),
(1,'granted', 'users', 'removeskill', NOW()),

(1,'granted', 'users', 'getlocations', NOW()),
(1,'granted', 'users', 'addlocation', NOW()),
(1,'granted', 'users', 'removelocation', NOW()),
(1,'granted', 'users', 'getinfos', NOW()),
(1,'granted', 'users', 'setinfos', NOW()),

(1,'granted', 'skills', 'getall', NOW()),

(1,'granted', 'locations', 'getall', NOW()),

(1,'granted', 'offers', 'getall', NOW()),
(1,'granted', 'offers', 'answer', NOW()),
(1,'granted', 'offers', 'getmines', NOW()),

(1,'granted', 'offers', 'getminesdraft', NOW()),
(1,'granted', 'offers', 'getminespublished', NOW()),
(1,'granted', 'offers', 'getskills', NOW()),
(1,'granted', 'offers', 'removeskill', NOW()),
(1,'granted', 'offers', 'addskill', NOW()),

(1,'granted', 'offers', 'getlocations', NOW()),
(1,'granted', 'offers', 'removelocation', NOW()),
(1,'granted', 'offers', 'addlocation', NOW()),
(1,'granted', 'offers', 'createdraft', NOW()),
(1,'granted', 'offers', 'removeoffer', NOW()),
(1,'granted', 'offers', 'view', NOW()),
(1,'granted', 'offers', 'getusersfromoffer', NOW()),
(1,'granted', 'offers', 'update', NOW())
;
