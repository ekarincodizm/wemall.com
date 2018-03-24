<?php

class SolrSearchRepository implements SolrSearchRepositoryInterface
{

    /**
     * @var PcmsClient
     */
    protected $pcmsClient;

    /**
     * @var mixed
     */
    protected $response;

    protected $suggest_limit = 10;

    public function __construct()
    {
        $this->pcmsClient = App::make('pcms');
    }

    /**
     * getData get data from PCMS auto-suggestion api v5
     * and parse data into usable JSON
     *
     * @param  string $q
     * @return array code, status, message, data
     */
    public function getAutoSuggestion($q = "")
    {
        $q = trim($q);
        $return_data = array(
            'code' => 200,
            'status' => 'success',
            'message' => 'success',
            'data' => array('suggestion' => array()),
        );

        if ( empty($q) ) {
            return $return_data;
        }

        $params['q'] = $q;

        try {
            $this->response = $this->pcmsClient->apiv5("auto-suggestion", $params, 'GET', TRUE);

            $response_code = array_get($this->response, 'code', false);
            if ($response_code != 200) {
                throw new Exception('Not has code or code not equal 200 in auto-suggestion api v5', 401);
            }

            $response_data = array_get($this->response, 'data', false);
            if (empty($response_data)) {
                throw new Exception('Not has data node in showroom api', 402);
            }

            $parse_data = $this->parseData($this->response);

            array_set($return_data, 'data', $parse_data);
        }
        catch (Exception $e) {
            array_set($return_data, 'code', $e->getCode());
            array_set($return_data, 'status', 'error');
            array_set($return_data, 'message', $e->getMessage());
            array_set($return_data, 'suggestion', array());
        }

        return $return_data;
    }

    /**
     * parseData from response
     * and return usable JSON format
     *
     * @param $response
     * @return array { page, total_page, showroom: [ { showroom_title, showroom_url, layout_id, layout_pattern, banner, brand, product } ] }
     * ] }
     * @throws Exception
     */
    public function parseData($response) {
        $parse_data = array('suggestion' => array());
        $lang = Lang::getLocale();

        $suggestion = array_get($response, 'data', false);

        if (empty($suggestion)) {
            throw new Exception('Suggestion data not found.', 401);
        }

        $suggestion_data = $suggestion['all'];

        if (! empty($suggestion_data)) {
            $i = 1;
            foreach ($suggestion_data as $key => $value) {
                if ($i > $this->suggest_limit) {
                    break;
                }

                $parse_data['suggestion'][] = array(
                    'result' => $key,
                    'found' => $value,
                );

                $i++;
            }
        }

        $parse_data['lang'] = $lang;

        return $parse_data;
    }

}
