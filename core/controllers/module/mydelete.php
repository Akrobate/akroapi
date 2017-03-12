<?php

/**
 * Generic delete CoreController
 * id is required in pg_parameters
 *
 */

class Module_Mydelete extends CoreController {

	public function init() {
        $userid = users::getId();
        $params = $this->getParams();
        if (isset($params->id)) {
            $id = $params->id;
            sql::query('DELETE FROM ' . $this->getModule() . " WHERE id = " . $id . " AND owner_user_id = " . $userid);
        }
	}
}
