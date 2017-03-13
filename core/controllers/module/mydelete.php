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
            $nbr_removed = sql::nbrAffectedRows();
            if (($nbr_removed !== null) && ($nbr_removed > 0)) {
                $this->assign('deleted', true);
            } else {
                $this->assign('deleted', false);
            }
        }
	}
}
