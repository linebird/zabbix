ALTER TABLE config ALTER COLUMN configid SET WITH DEFAULT NULL
/
REORG TABLE config
/
ALTER TABLE config ALTER COLUMN alert_usrgrpid SET WITH DEFAULT NULL
/
REORG TABLE config
/
ALTER TABLE config ALTER COLUMN alert_usrgrpid DROP NOT NULL
/
REORG TABLE config
/
ALTER TABLE config ALTER COLUMN discovery_groupid SET WITH DEFAULT NULL
/
REORG TABLE config
/
ALTER TABLE config ADD ns_support integer DEFAULT '0' NOT NULL
/
REORG TABLE config
/
UPDATE config SET alert_usrgrpid=NULL WHERE alert_usrgrpid NOT IN (SELECT usrgrpid FROM usrgrp)
/
UPDATE config SET discovery_groupid=NULL WHERE discovery_groupid NOT IN (SELECT groupid FROM groups)
/
UPDATE config SET default_theme='css_ob.css' WHERE default_theme='default.css'
/
ALTER TABLE config ADD CONSTRAINT c_config_1 FOREIGN KEY (alert_usrgrpid) REFERENCES usrgrp (usrgrpid)
/
REORG TABLE config
/
ALTER TABLE config ADD CONSTRAINT c_config_2 FOREIGN KEY (discovery_groupid) REFERENCES groups (groupid)
/
REORG TABLE config
/
