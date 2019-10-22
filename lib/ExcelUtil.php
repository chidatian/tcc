<?php

/**
* "phpoffice/phpexcel": "1.8.2"
* composer require phpoffice/phpexcel:1.8.2
*/
class ExcelUtil
{
	/**
     * excel export
     * @param array $title ['id', 'name', 'sex']
     * @param array $data [ ['id' => 1, 'name' => 'ss'], ['id' => 1, 'name' => 'ss'] ...  ]
     */
    public function exportExcel($title, $data)
    {
        $range =range('A','Z');
        //生成excel文件
        // vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        //列标题
        for($i = 0; $i < count($title); $i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(($range[$i]."1"),$title[$i]);
        }
        //列数值
        for($i = 0; $i < sizeof($data); $i++){
            $dataListValue = array_values($data[$i]);
            for($j=0;$j<count($dataListValue);$j++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue(($range[$j].($i+2)),$dataListValue[$j]);
            }
        }
        
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=".date('YmdHis').".xls");
        header("Content-Type: application/vnd.ms-excel;");
        header("Content-Transfer-Encoding: binary");
        
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }
}