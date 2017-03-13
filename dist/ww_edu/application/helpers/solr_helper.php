<?php  

class solr{
    private $options = array('hostname' => 'localhost', 'port' => '8983', 'path' => '/solr/videos');
	private $client;

	public static function build() {
        return new solr();
    }

    public function __construct()
    {
        $this->client = new SolrClient($this->options);
    }

    function getQuery($q, $start, $limit)
    {
        $query = new SolrQuery();

        $query->setQuery($q);

        $query->setStart($start);

        $query->setRows($limit);

        $query_response = $this->client->query($query);

        $response = $query_response->getResponse();

        return json_encode($response);
    }

    function add_update($data)
    {
		$doc = new SolrInputDocument();
		foreach($data as $key => $val)
		{
			$doc->addField($key, $val);
		}	

		$response = $this->client->addDocument($doc);

		// print_r($response->getResponse());
    }

    function delete($id)
    {
    	$result = $this->client->deleteByQuery("id={$id}");
    }
}
