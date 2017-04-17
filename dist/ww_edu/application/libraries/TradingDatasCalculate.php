<?php  

class TradingDatasCalculate
{
	private $calculate_datas;

	private $mt4_datas;

	public function __construct($mt4_datas)
	{
		$this->mt4_datas = $mt4_datas;
		$this->calculate_datas = $calculate_datas;
	}

	public function BuyNo()
	{
		return $this;
	}
}