<?php

namespace App\Domain\Pro;
use App\Model\Pro\Pro as ProModel;

/**
 * 用户
 *
 * - 可用于自动生成一个新用户
 *
 * @author dogstar 20200331
 */

class Pro {

    public function getProByTypeAndTs($proId, $type, $ts, $select = '*') {
        $model = new ProModel();
        return $model->getInfo($proId, $type, $ts, $select);
    }

    /**
     * 获取币种信息
     * @param unknown $pid
     * @return array|unknown
     */
    public function setProInfo($moreInfo = array()) {
        $proModel = new ProModel();

        $newProInfo = $moreInfo;
        $id = $proModel->insert($newProInfo);
        return intval($id);
    }

    /**
     * 获取币种信息
     * @param unknown $pid
     * @return array|unknown
     */
    public function getProInfo($pid, $select = '*') {
        $rs = array();
        
        $pid = intval($pid);
        if ($pid <= 0) {
            return $rs;
        }
        
        $model = new ProModel();
        $rs = $model->getDescInfo($pid);
        if (empty($rs)) {
            return [];
        }
        
        $rs['pid'] = intval($rs['pid']);
        return $rs;
    }
    
    public function getProByProIds($pid) {
        $rs = array();
        
        $model = new ProModel();
        $rs = $model->getSnapshotByProIds($pid);
        if (empty($rs)) {
            return [];
        }
        
        $rs['pid'] = intval($rs['pid']);
        return $rs;
    }

    public function getAllInfo() {
        $rs = array();
        
        $model = new ProModel();
        $rs = $model->getProAllInfo();
        return $rs;
    }
}