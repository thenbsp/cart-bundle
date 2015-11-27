<?php

namespace Thenbsp\CartBundle\Utils;

class CurrencyUtils
{
    /**
     * 配置参数
     */
    protected $parameter;

    /**
     * 构造方法
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * 转为标准的 Float 值
     */
    public function toCurrency($value)
    {
        return round($value,
            $this->parameter['precision'],
            $this->parameter['mode']);
    }

    /**
     * 转为格式化金额
     */
    public function toFormated($value)
    {
        return number_format($value,
            $this->parameter['decimals'],
            $this->parameter['dec_point'],
            $this->parameter['thousands_sep']);
    }
}
