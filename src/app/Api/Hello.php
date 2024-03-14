<?php

namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception\BadRequestException;
use App\Domain\Pro\Pro as ProDomain;

/**
 * 币种信息
 */
class Hello extends Api {
	protected $profile = array();

	public function getRules() {
        return array(
            'getProinfo' => array(
            	'rtp' => array('name' => 'rtp', 'require' => true, 'desc' => '查询方式【GetQuotesDetail（1）|CandleStick（200）】'),
                'pid' => array('name' => 'pid', 'require' => true, 'desc' => '币种ID需要唯一'),
                'type' => array('name' => 'type', 'require' => false, 'desc' => '"1min" = 1,"5min" = 2,"15min" = 3,"30min" = 4,"60min" = 5,"1day" = 6,"1week" = 7,"1mon" = 8,"1year" = 9'),
            ),
        );
    }

    /**
	 * 币种信息接口
	 * @desc 根据pid获取币种详情
	 */
	public function setProinfo() {
		$result = [];
		$ProDomain = new ProDomain();
		$ids = [12,13,14,15,22,23,24,25,26,28,29,30,31,33,34,51,52,53,55,56,57,58,59,60,61];
		foreach ($ids as $pid) {
			$result = \App\curlGetData('https://m.sojex.net/api.do?rtp=CandleStick&type=1&qid='.$pid);
			$data = json_decode($result, true);
			$ptitle = $data['data']['info']['name'];
			$candle = $data['data']['candle'];
			// $candle = array_reverse($candle);
			foreach ($candle as $key => $item) {
				$pro = $ProDomain->getProByTypeAndTs($pid, 1, $item['ts'], $select = '*');
		        if ($pro) {
		        	continue;
		        	//throw new BadRequestException($ptitle . $item['t'] . '已注册');
		        }
		        $moreInfo = array(
		        	'pid' => $pid,
		        	'ptitle' => $ptitle,
		        	'type' => 1,
		            'o' => $item['o'],
		            'h' => $item['h'],
		            'l' => $item['l'],
		            'c' => $item['c'],
		            'a' => $item['a'],
		            'v' => $item['v'],
		            'ts' =>$item['ts'],
		            't' => $item['t']
		        );
		        $result = $ProDomain->setProInfo($moreInfo);
			}
		}
        return array('data' => [], 'msg' => '采集成功');
	}

	/**
	 * 币种信息接口
	 * @desc 根据pid获取币种详情
	 */
	public function getProinfo() {
		$ProDomain = new ProDomain();
		if ($this->rtp == 'GetQuotesDetail') {
			$profile = $ProDomain->getProInfo($this->pid, '*');
        	$this->profile = $profile ? $profile : $this->profile;
		} else if ($this->rtp == 'CandleStick') {
			$profile = $ProDomain->getProInfo($this->pid, '*');
        	$this->profile = $profile ? $profile : $this->profile;
		}
        
        return $profile;
	}

	/**
	 * 所有币种信息接口
	 * @desc 获取所有币种信息
	 */
	public function getProsinfo() {
		$ProDomain = new ProDomain();
        $profile = $ProDomain->getAllInfo();
        $this->profile = $profile ? $profile : $this->profile;
        return array($profile);
	}
}