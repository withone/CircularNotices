<?php
/**
 * CircularNoticesAppController::initCircularNotice()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('CircularNoticesAppController', 'CircularNotices.Controller');

/**
 * CircularNoticesAppController::initCircularNotice()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticesAppController
 */
class CircularNoticesAppControllerInitCircularNoticeTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.circular_notices.circular_notice_frame_setting',
		'plugin.circular_notices.circular_notice_setting',
		'plugin.frames.frame',
		'plugin.blocks.block',
	);

/**
 * initCircularNoticeメソッド用DataProvider
 *
 * #### 戻り値
 *  - data: テストデータ
 *  - assert: テストの期待値
 *  - exception: Exception
 *
 * @return array
 */
	public function dataInitCircularNotice() {
		$results = array();
		$results[0] = array(
			'data' => array(
				'Frame.id' => 1,
				'Frame.key' => '',
			),
			'assert' => null,
			'exception' => 'BadRequestException'
		);
		$results[1] = array(
			'data' => array(
				'Frame.id' => 5,
				'Frame.key' => ''
			),
			'assert' => null,
			'exception' => 'BadRequestException'
		);
		$results[2] = array(
			'data' => array(
				'Frame.id' => 5,
				'Frame.key' => 'frame_1'
			),
			'assert' => array(
				'method' => 'assertNotEmpty',
			),
		);

		return $results;
	}

/**
 * initCircularNoticeメソッドテスト
 *
 * @param array $data
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @dataProvider dataInitCircularNotice
 * @return void
 * @throws BadRequestException
 */
	public function testInitCircularNotice($data, $assert, $exception = null) {
		if ($exception) {
			$this->setExpectedException($exception);
		}

		$stub = $this->getMockBuilder('CircularNoticesAppController')->setMethods(['throwBadRequest'])->getMock();
		$stub->expects($this->any())->method('throwBadRequest')->will($this->returnCallback(
			function () {
				throw new BadRequestException('test');
			}
		));

		foreach ($data as $key => $value) {
			Current::write($key, $value);
		}

		$stub->initCircularNotice();

		if ($assert) {
			$this->$assert['method']($stub->viewVars);
		}
	}
}