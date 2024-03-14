<?php
namespace App\Model\Pro;
use PhalApi\Model\DataModel;

class Pro extends DataModel {

    protected function getTableName($id) {
        return 'productinfo';
    }

    /**
     * 获取全部prodata
     */
    public function getProAllInfo() {
        $rs = array();
        $rows =$this->getORM()->select('*')->fetchAll();
        foreach ($rows as $row) {
            $rs[$row['pid']] = $row;
        }
        return $rs;
    }

    /**
     * pid获取prodata
     */
    public function getDescInfo($proId) {
        return $this->getORM()->select('*')->where('pid = ?', $proId)->order('ts DESC')->fetch();
    }

    /**
     * pid获取prodata
     */
    public function getInfo($proId, $type, $ts) {
        return $this->getORM()->select('*')->where('pid = ?', $proId)->where('type = ?', $type)->where('ts = ?', $ts)->fetch();
    }

    /**
     * 批量获取用户快照，并进行反转，以便外部查找
     */
    public function getSnapshotByProIds(array $proIds)
    {
        $rs = array();
        if (empty($proIds)) {
            return $rs;
        }

        $rows =self::getORM()
            ->select('*')
            ->where('pid', $proIds)
            ->fetchAll();

        foreach ($rows as $row) {
            $rs[$row['pid']] = $row;
        }

        return $rs;
    }
}