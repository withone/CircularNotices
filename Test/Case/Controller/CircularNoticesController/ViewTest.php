<?php
/**
 * CircularNoticesController::view()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * CircularNoticesController::view()のテスト
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\Case\Controller\CircularNoticesController
 */
class CircularNoticesControllerViewTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.circular_notices.circular_notice_choice',
		'plugin.circular_notices.circular_notice_content',
		'plugin.circular_notices.circular_notice_frame_setting',
		'plugin.circular_notices.circular_notice_setting',
		'plugin.circular_notices.circular_notice_target_user',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.frames.frame',
		'plugin.blocks.block',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'circular_notices';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'circular_notices';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getData() {
		$frameId = '5';
		$blockId = '1';
		$contentKey = 'circular_notice_content_1';

		$data = array(
			'frame_id' => $frameId,
			'block_id' => $blockId,
			'key' => $contentKey,
		);

		return $data;
	}

/**
 * viewアクションのテスト(作成権限のみ)用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderView() {
		$data = $this->__getData();

		//テストデータ
		$results = array();

		$results[0] = array(
			'urlOptions' => Hash::insert($data, 'frame_id', ''),
			'assert' => null,
			'exception' => 'BadRequestException'
		);
		$results[1] = array(
			'urlOptions' => Hash::insert($data, 'key', 'a'),
			'assert' => null,
			'exception' => 'BadRequestException'
		);
		$results[2] = array(
			'urlOptions' => $data,
			'assert' => array('method' => 'assertNotEmpty'),
		);

		return $results;
	}

/**
 * viewアクションのテスト(作成権限のみ)
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderView
 * @return void
 */
	public function testView($urlOptions, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'view',
		), $urlOptions);
		$this->_testGetAction($url, $assert, $exception, $return);

		//ログアウト
		TestAuthGeneral::logout($this);
	}

/**
 * view回答アクションのテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderViewPost() {
		$data = $this->__getData();
		return array(
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_1'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_1',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 1,
						'reply_text_value' => '',
					),
				),
				'assert' => array('method' => 'assertNotEmpty'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_1'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_1',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 1,
						'reply_text_value' => 'Lorem ipsum dolor sit amet',
					),
				),
				'assert' => array('method' => 'assertNotEmpty'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_2'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_2',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 2,
						'reply_selection_value' => 'Lorem ipsum dolor sit amet',
					),
				),
				'assert' => array('method' => 'assertNotEmpty'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_3'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_3',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 3,
						'reply_selection_value' => array(
							'Lorem ipsum dolor sit amet',
							'Convallis morbi fringilla gravida'
						),
					),
				),
				'assert' => array('method' => 'assertNotEmpty'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_10'),
				'data' => array(
						'CircularNoticeContent' => array(
								'key' => 'circular_notice_content_10',
						),
						'CircularNoticeTargetUser' => array(
								'id' => 10,
								'reply_text_value' => '',
						),
				),
				'assert' => array('method' => 'assertNotEmpty'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_11'),
				'data' => array(
						'CircularNoticeContent' => array(
								'key' => 'circular_notice_content_11',
						),
						'CircularNoticeTargetUser' => array(
								'id' => 11,
								'reply_text_value' => '',
								'reply_selection_value' => '',
						),
				),
				'assert' => array('method' => 'assertNotEmpty'),
			),
			array(
				'urlOptions' => Hash::insert($data, 'key', 'circular_notice_content_12'),
				'data' => array(
					'CircularNoticeContent' => array(
						'key' => 'circular_notice_content_12',
					),
					'CircularNoticeTargetUser' => array(
						'id' => 12,
						'reply_selection_value' => array(),
					),
				),
				'assert' => array('method' => 'assertNotEmpty'),
			));
	}

/**
 * editアクションのPOSTテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $data POSTデータ
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderViewPost
 * @return void
 */
	public function testViewPost($urlOptions, $data, $assert, $exception = null, $return = 'view') {
		//ログイン
		TestAuthGeneral::login($this, Role::ROOM_ROLE_KEY_GENERAL_USER);
		//テスト実施
		$this->_testPostAction('put', $data, Hash::merge(array('action' => 'view'), $urlOptions), $exception, $return);
		//ログイン
		TestAuthGeneral::logout($this);
	}
}