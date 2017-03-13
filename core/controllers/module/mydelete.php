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
            if ($nbr_removed === null) {
                $this->assign('deleted', false);
                $this->assign('nbr', $nbr_removed);
            } else {
                $this->assign('deleted', true);
                $this->assign('nbr', $nbr_removed);
            }
        }
	}
}
