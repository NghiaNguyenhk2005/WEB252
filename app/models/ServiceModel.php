<?php

/**
 * Quản lý dữ liệu Dịch vụ doanh nghiệp
 */
class ServiceModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "services");
    }
}