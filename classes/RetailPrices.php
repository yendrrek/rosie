<?php
class RetailPrices
{
    public $productsRetailPrices = []; 
    
	public function getRetailPrices()
	{
		if (!empty($_SESSION['shopProductsData'])) {
			foreach ($_SESSION['shopProductsData'] as $product) {
				$this->productsRetailPrices[] = $product['retailPrice'];
			}
			// Make the index of the array with retail prices start from 1. That index is matched later against the id of a product being added to the basket, so the relevant price can be displayed. 
			array_unshift($this->productsRetailPrices, ''); /* https://stackoverflow.com/a/5374303/12208549 */
			unset($this->productsRetailPrices[0]);
		}
	}
}