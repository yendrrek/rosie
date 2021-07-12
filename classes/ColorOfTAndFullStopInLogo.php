<?php
class ColorOfTAndFullStopInLogo 
{
    public $colorOfFullStopInLogo;
    public $colorOfTInLogo;

    public function setTAndFullStopColor()
    { 
    	$currentPage = '';
        $pagesWillHaveLogoOrange = $pagesWillHaveLogoGreen =
        $pagesWillHaveLogoYellow = $pagesWillHaveLogoBrown = false;

    	$currentPage = $_SERVER['REQUEST_URI'];

		$pagesWillHaveLogoOrange = (
			strpos($currentPage, 'all-works') !== false ||
			strpos($currentPage, 'paintings') !== false
		);
		$pagesWillHaveLogoGreen = (strpos($currentPage, 'geometry') !== false);
		$pagesWillHaveLogoYellow = (strpos($currentPage, 'stained-glass') !== false);
		$pagesWillHaveLogoBrown = (strpos($currentPage, 'ceramic-tiles') !== false);

		switch (true) {
			case $pagesWillHaveLogoOrange:
				$this->colorOfTInLogo = 'logo__letter-t_orange';
				$this->colorOfFullStopInLogo = 'logo__full-stop_orange';
				break;
			case $pagesWillHaveLogoGreen:
				$this->colorOfTInLogo = 'logo__letter-t_green';
				$this->colorOfFullStopInLogo = 'logo__full-stop_green';
				break;
			case $pagesWillHaveLogoYellow:
			    $this->colorOfTInLogo = 'logo__letter-t_yellow';
			    $this->colorOfFullStopInLogo = 'logo__full-stop_yellow';
			    break;
			case $pagesWillHaveLogoBrown:
			    $this->colorOfTInLogo = 'logo__letter-t_brown';
			    $this->colorOfFullStopInLogo = 'logo__full-stop_brown';
			    break;
		}
    }
}