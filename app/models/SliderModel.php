<?php

/**
 * Quản lý dữ liệu Banner / Slider trang chủ
 */
class SliderModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "sliders");
    }

    /**
     * Lấy các slide đang kích hoạt theo thứ tự hiển thị
     */
    public function getActiveSliders() {
        return $this->where('status', 1)->orderBy('display_order', 'ASC')->get();
    }
}