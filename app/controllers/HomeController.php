<?php
class HomeController extends BaseController {
    private $sliderModel;

    public function __construct($conn) {
        $this->sliderModel = new SliderModel($conn);
    }

    public function index() {
        global $globalSettings;
        $activeSliders = $this->sliderModel->getActive();
        $this->view('client/home', [
            'globalSettings' => $globalSettings,
            'activeSliders'  => $activeSliders,
        ]);
    }
}
