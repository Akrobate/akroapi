<?php

/**
 * Generic delete CoreController
 * id is required in pg_parameters
 *
 */

class Module_Delete extends CoreController {

	public function init() {
        $params = $this->getParams();
        if (isset($params->id)) {
            $id = $params->id;
            sql::query('DELETE FROM ' . $this->getModule() . " WHERE id = " . $id);
        }
	}
}
