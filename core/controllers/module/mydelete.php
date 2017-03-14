<?php

/**
 * Generic delete CoreController
 * id is required in pg_parameters
 *
 */

class Module_Mydelete extends CoreController {

	public function init() {
        $params = $this->getParams();
        if (isset($params->id)) {
            $orm = new UserOrmNode(users::getId());
            $result = $orm->removeData($this->getModule(), $params->id);
            // returns boolean - true if element was removed
            $this->assign('deleted', $result);
        }
	}
}
