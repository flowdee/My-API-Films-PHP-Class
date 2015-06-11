<?php

class My_API_Films {

    // API settings
    private $api_url = 'http://www.myapifilms.com/imdb';

    // User credentials
    private $token = false;

    # Constructor
    public function My_API_Films() {

    }

    /**
     * Set API token
     */
    public function set_token($token)
    {
        // Initialize
        $this->token = $token;
    }

    /**
     * Get entry by id
     */
    public function get_entry_by_id($id, $param = false, $returnObject = false)
    {
        // Build call
        $set = 'idIMDB=' . $id;

        if ($param && is_array($param)) {

            if(isset($param['trailer'])) {
                $set .= '&trailer=1';
            }

            if(isset($param['actors'])) {
                // s = Simple, f = Full
                $set .= '&actors=' . strtoupper($param['actors']);
            }
        }

        // Make call
        $result = $this->call($set);

        // Return array instead of object
        if (!$returnObject) {
            return $this->object_to_array($result);
        }

        return $result;
    }

    /*
     * Get entry poster
     */
    public function get_entry_poster($id) {

        $entry = $this->get_entry_by_id($id);

        if (isset($entry['urlPoster'])) {
            return $entry['urlPoster'];
        }

        return false;
    }

    /*
     * Get entry trailer
     */
    public function get_entry_trailer($id) {

        $entry = $this->get_entry_by_id($id, array('trailer' => true));

        if (isset($entry['trailer']['videoURL'])) {
            return $entry['trailer']['videoURL'];
        }

        return false;
    }


    /**
     * Make an API call including optional token
     */
    protected function call($set)
    {

        if ( $this->token ) {
            $token = '&token=' . $this->token;
        } else {
            $token = '';
        }

        $url = $this->api_url . '?format=JSON&' . $set . $token;

        $result = $this->fetch($url);

        if ( isset($result->error) ) return 'Sorry something went wrong with your request.';

        return $result;
    }

    /*
    * Either fetches the desired data from the API and caches it, or fetches the cached version
    *
    * @param string $url The url to the API call
    * @param string $set (optional) The name of the set to retrieve.
    */
    protected function fetch($url, $set = null)
    {
        $data = $this->curl($url);

        if ($data) {
            $data = isset($set) ? $data->{$set} : $data; // if a set is needed, update
        } else exit('Could not retrieve data.');

        return $data;
    }

    /**
     * General purpose function to query My API Films.
     *
     * @param string $url The url to access, via curl.
     * @return object The results of the curl request.
     */
    protected function curl($url)
    {
        if ( empty($url) ) return false;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; My API Films PHP Class)');

        $data = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($data);

        return $data; // string or null
    }

    /*
     * Object to Array
     */
    protected function object_to_array($object) {
        return json_decode(json_encode($object), true);
    }

}