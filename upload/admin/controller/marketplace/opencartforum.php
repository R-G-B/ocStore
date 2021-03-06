<?php
class ControllerMarketplaceOpencartforum extends Controller {
	public function index() {
        $this->load->language('marketplace/opencartforum');

		$this->document->setTitle($this->language->get('heading_title'));

        $data['heading_title'] = $this->language->get('heading_title');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['button_filter'] = $this->language->get('button_filter');
        $data['text_category'] = $this->language->get('text_category');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_search'] = $this->language->get('text_search');
        $data['text_reviews'] = $this->language->get('text_reviews');
        $data['text_no_results'] = $this->language->get('text_no_results');


		if (isset($this->request->get['filter_search'])) {
			$filter_search = $this->request->get['filter_search'];
		} else {
			$filter_search = '';
		}

		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = '';
		}

		if (isset($this->request->get['filter_license'])) {
			$filter_license = $this->request->get['filter_license'];
		} else {
			$filter_license = '';
		}

		if (isset($this->request->get['filter_rating'])) {
			$filter_rating = $this->request->get['filter_rating'];
		} else {
			$filter_rating = '';
		}

		if (isset($this->request->get['filter_member_type'])) {
			$filter_member_type = $this->request->get['filter_member_type'];
		} else {
			$filter_member_type = '';
		}

		if (isset($this->request->get['filter_member'])) {
			$filter_member = $this->request->get['filter_member'];
		} else {
			$filter_member = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_modified';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_search'])) {
			$url .= '&filter_search=' . $this->request->get['filter_search'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . $this->request->get['filter_rating'];
		}

		if (isset($this->request->get['filter_member_type'])) {
			$url .= '&filter_member_type=' . $this->request->get['filter_member_type'];
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . $this->request->get['filter_member'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$time = time();
		
		// We create a hash from the data in a similar method to how amazon does things.

		$url .= '&domain=' . $this->request->server['HTTP_HOST'];
		$url .= '&version=' . urlencode(VERSION);
		$url .= '&time=' . $time;
        $url .= '&language=' . $this->language->get('code');

		if (isset($this->request->get['filter_search'])) {
			$url .= '&filter_search=' . urlencode($this->request->get['filter_search']);
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . $this->request->get['filter_rating'];
		}

		if (isset($this->request->get['filter_member_type'])) {
			$url .= '&filter_member_type=' . $this->request->get['filter_member_type'];
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . $this->request->get['filter_member'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$curl = curl_init(OPENCARTFORUM_SERVER . 'marketplace/api?' . $url);


		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);

		$response = curl_exec($curl);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		$response_info = json_decode($response, true);

		$extension_total = strip_tags($response_info['extension_total']);

		$url  = '';

		if (isset($this->request->get['filter_search'])) {
			$url .= '&filter_search=' . $this->request->get['filter_search'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . $this->request->get['filter_rating'];
		}

		if (isset($this->request->get['filter_member_type'])) {
			$url .= '&filter_member_type=' . $this->request->get['filter_member_type'];
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . $this->request->get['filter_member'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

        $allowed_tags = "";

		$data['promotions'] = array();

        $promotions = $this->strip($response_info['promotions'],  $allowed_tags);

        if ($promotions && $page == 1) {
            foreach ($promotions as $result) {
                $data['promotions'][] = array(
                    'name' => $result['name'],
                    'description' => $result['description'],
                    'image' => $result['image'],
                    'license' => $result['license'],
                    'price' => $result['price'],
                    'rating' => $result['rating'],
                    'rating_total' => $result['rating_total'],
                    'href' => $this->url->link('marketplace/opencartforum/info', 'token=' . $this->session->data['token'] . '&extension_id=' . $result['extension_id'] . $url, true)
                );
            }
        }

		$data['extensions'] = array();

        $extensions = $this->strip($response_info['extensions'],  $allowed_tags);

		if ($extensions) {
			foreach ($extensions as $result) {
				$data['extensions'][] = array(
					'name'         => $result['name'],
					'description'  => $result['description'],
					'image'        => $result['image'],
					'license'      => $result['license'],
					'price'        => $result['price'],
					'rating'       => $result['rating'],
					'rating_total' => $result['rating_total'],
					'href'         => $this->url->link('marketplace/opencartforum/info', 'token=' . $this->session->data['token'] . '&extension_id=' . $result['extension_id'] . $url, true)
				);
			}
		}

		$data['token'] = $this->session->data['token'];

		// Categories
		$url = '';

		if (isset($this->request->get['filter_search'])) {
			$url .= '&filter_search=' . $this->request->get['filter_search'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . $this->request->get['filter_rating'];
		}

		if (isset($this->request->get['filter_member_type'])) {
			$url .= '&filter_member_type=' . $this->request->get['filter_member_type'];
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . $this->request->get['filter_member'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		$data['categories'] = array();

		$data['categories'][] = array(
			'text'  => $this->language->get('text_all'),
			'value' => '',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url, true)
		);

        $data['categories'][] = array(
            'text'  => $this->language->get('text_besplatnye_shablony'),
            'value' => '10',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=10' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_platnye_shablony'),
            'value' => '11',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=11' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_filtry'),
            'value' => '36',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=36' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_ceny_skidki_akcii_podarki'),
            'value' => '38',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=38' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_bonusy_kupony_programmy_loyalnosti'),
            'value' => '44',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=44' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_blogi_novosti_stati'),
            'value' => '45',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=45' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_pokupki_oformlenie_zakaza_korzina'),
            'value' => '51',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=51' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_opcii'),
            'value' => '60',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=60' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_atributy'),
            'value' => '65',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=65' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_serii_komplekty'),
            'value' => '63',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=63' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_poisk'),
            'value' => '57',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=57' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_seo_karta_sayta_optimizaciya'),
            'value' => '53',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=53' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_keshirovanie_szhatie_uskorenie'),
            'value' => '54',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=54' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_platezhnye_sistemy'),
            'value' => '5',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=5' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_dostavki'),
            'value' => '7',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=7' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_redaktory'),
            'value' => '72',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=72' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_menyu_dizayn_vneshniy_vid'),
            'value' => '80',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=80' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_slaydshou_bannery_galerei'),
            'value' => '78',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=78' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_pisma_pochta_rassylki_sms'),
            'value' => '66',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=66' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_obratnaya_svyaz_zvonki'),
            'value' => '75',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=75' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_obmen_dannymi'),
            'value' => '6',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=6' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_uchet_v_zakaze'),
            'value' => '8',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=8' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_sravneniya_zakladki'),
            'value' => '77',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=77' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_socialnye_seti'),
            'value' => '13',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=13' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_parsery'),
            'value' => '69',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=69' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_moduli'),
            'value' => '2',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=2' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_instrumenty_utility'),
            'value' => '71',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=71' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_licenzii'),
            'value' => '23',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=23' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_yazykovye_pakety'),
            'value' => '4',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=4' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_prochee'),
            'value' => '3',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=3' . $url, true)
        );

        $data['categories'][] = array(
            'text'  => $this->language->get('text_otchety'),
            'value' => '9',
            'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_category=9' . $url, true)
        );

		// Licenses
		$url = '';

		if (isset($this->request->get['filter_search'])) {
			$url .= '&filter_search=' . $this->request->get['filter_search'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . $this->request->get['filter_rating'];
		}

		if (isset($this->request->get['filter_member_type'])) {
			$url .= '&filter_member_type=' . $this->request->get['filter_member_type'];
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . $this->request->get['filter_member'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['licenses'] = array();

		$data['licenses'][] = array(
			'text'  => $this->language->get('text_all'),
			'value' => '',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['licenses'][] = array(
			'text'  => $this->language->get('text_free'),
			'value' => 'free',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_license=free' . $url, true)
		);

		$data['licenses'][] = array(
			'text'  => $this->language->get('text_paid'),
			'value' => 'paid',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_license=paid' . $url, true)
		);

		// Sort
		$url = '';

		if (isset($this->request->get['filter_search'])) {
			$url .= '&filter_search=' . $this->request->get['filter_search'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . $this->request->get['filter_rating'];
		}

		if (isset($this->request->get['filter_member_type'])) {
			$url .= '&filter_member_type=' . $this->request->get['filter_member_type'];
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . $this->request->get['filter_member'];
		}

		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_date_modified'),
			'value' => 'date_modified',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url . '&sort=date_modified')
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_date_added'),
			'value' => 'date_added',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url . '&sort=date_added')
		);

		/*$data['sorts'][] = array(
			'text'  => $this->language->get('text_rating'),
			'value' => 'rating',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url . '&sort=rating')
		);*/


		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name'),
			'value' => 'name',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url . '&sort=name')
		);

		/*$data['sorts'][] = array(
			'text'  => $this->language->get('text_price'),
			'value' => 'price',
			'href'  => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url . '&sort=price')
		);*/

		// Pagination
		$url = '';

		if (isset($this->request->get['filter_search'])) {
			$url .= '&filter_search=' . $this->request->get['filter_search'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_license'])) {
			$url .= '&filter_license=' . $this->request->get['filter_license'];
		}

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . $this->request->get['filter_rating'];
		}

		if (isset($this->request->get['filter_member_type'])) {
			$url .= '&filter_member_type=' . $this->request->get['filter_member_type'];
		}

		if (isset($this->request->get['filter_member'])) {
			$url .= '&filter_member=' . $this->request->get['filter_member'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		$pagination = new Pagination();
		$pagination->total = (int)$extension_total;
		$pagination->page = $page;
		$pagination->limit = 12;
		$pagination->url = $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['filter_search'] = $filter_search;
		$data['filter_category'] = $filter_category;
		$data['filter_license'] = $filter_license;
		$data['filter_member_type'] = $filter_member_type;
		$data['filter_rating'] = $filter_rating;
		$data['sort'] = $sort;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketplace/opencartforum_list', $data));
	}

	public function info() {
		if (isset($this->request->get['extension_id'])) {
			$extension_id = $this->request->get['extension_id'];
		} else {
			$extension_id = 0;
		}

        $this->load->language('marketplace/opencartforum');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['heading_title'] = $this->language->get('heading_title');
        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_changelog'] = $this->language->get('tab_changelog');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_purchase'] = $this->language->get('button_purchase');
        $data['button_view_all'] = $this->language->get('button_view_all');
        $data['button_get_support'] = $this->language->get('button_get_support');
        $data['text_rating'] = $this->language->get('text_rating');
        $data['text_member_since'] = $this->language->get('text_member_since');
        $data['text_downloaded'] = $this->language->get('text_downloaded');
        $data['text_sales'] = $this->language->get('text_sales');
        $data['text_date_added'] = $this->language->get('text_date_added');
        $data['text_date_modified'] = $this->language->get('text_date_modified');
        $data['text_price'] = $this->language->get('text_price');

		$time = time();
		$url = '&domain=' . $this->request->server['HTTP_HOST'];
		$url .= '&version=' . urlencode(VERSION);
		$url .= '&extension_id=' . $extension_id;
		$url .= '&time=' . $time;
		$url .= '&language=' . $this->language->get('code');

		$curl = curl_init(OPENCARTFORUM_SERVER . 'marketplace/api/info?' . $url);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);

		$response = curl_exec($curl);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		$response_info = json_decode($response, true);

		if ($response_info) {
			$this->load->language('marketplace/opencartforum');

			$this->document->setTitle($this->language->get('heading_title'));


			$data['token'] = $this->session->data['token'];

			$url = '';

			if (isset($this->request->get['filter_search'])) {
				$url .= '&filter_search=' . $this->request->get['filter_search'];
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_license'])) {
				$url .= '&filter_license=' . $this->request->get['filter_license'];
			}

			if (isset($this->request->get['filter_username'])) {
				$url .= '&filter_username=' . $this->request->get['filter_username'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['cancel'] = $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url, true);

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . $url, true)
			);



            $this->document->setTitle($this->language->get('heading_title'));

            $allowed_tags = "<p><a><ul><li>";

            $response_info = $this->strip($response_info,  $allowed_tags);

            foreach ($response_info as $key => $value) {
                $data[$key] = $value;
            }

			$data['filter_member'] = $this->url->link('marketplace/opencartforum', 'token=' . $this->session->data['token'] . '&filter_member=' . strip_tags($response_info['member_username']));





			$this->document->addStyle('view/javascript/jquery/magnific/magnific-popup.css');
			$this->document->addScript('view/javascript/jquery/magnific/jquery.magnific-popup.min.js');

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('marketplace/opencartforum_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}

    private function strip($string, $allowed_tags = NULL) {
	    if (is_array($string))  {
	        foreach ($string as $k => $v) {
	        $string[$k] = $this->strip($v, $allowed_tags); } return $string;
	    }
	    return strip_tags($string, $allowed_tags);
	}

}
