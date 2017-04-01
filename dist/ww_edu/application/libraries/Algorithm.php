<?php  
/**
 * algorithm for mt4 datas
 */
class Algorithm
{
	private $mt4_data = [];

	public function __construct(array $mt4_data)
	{
		$this->mt4_data = $mt4_data;
	}

	public function best_trading_currency_pair()
	{
		return $this;
	}

	public function order_lots()
	{
		return $this;
	}

	public function max_single_order_profit()
	{
		return $this;
	}

	public function aug_positoin_time()
	{
		return $this;
	}

	public function trading_cycle()
	{
		return $this;
	}

	public function profit_rate()
	{
		return $this;
	}

	public function profit_loss_rate()
	{
		return $this;
	}

	public function max_profit()
	{
		return $this;
	}

	public function max_loss()
	{
		return $this;
	}

	public function max_profit_points()
	{
		return $this;
	}

	public function profit_loss_points()
	{
		return $this;
	}

	public function total_trading()
	{
		return $this;
	}

	public function aug_profit()
	{
		return $this;
	}

	public function daily_trading()
	{
		return $this;
	}

	public function aug_loss()
	{
		return $this;
	}

	public function daily_profit_loss()
	{
		return $this;
	}

}
