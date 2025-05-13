<?php
// CSP报告接收接口
// 设置响应头
header('Content-Type: application/json');

// 仅接受POST请求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Only POST requests are accepted'));
    exit;
}

// 获取原始POST数据
$json_data = file_get_contents('php://input');

// 解码JSON数据
$report_data = json_decode($json_data, true);

// 验证JSON数据
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Invalid JSON data'));
    exit;
}

// 记录CSP违规报告到日志文件
function log_csp_violation($report) {
    $log_file = 'app/pages/csp-reports.log';
    
    // 准备日志条目
    $log_entry = sprintf(
        "[%s] CSP Violation: %s\nBlocked URI: %s\nDocument URI: %s\nViolated Directive: %s\nUser Agent: %s\n\n",
        date('Y-m-d H:i:s'),
        isset($report['csp-report']['effective-directive']) ? $report['csp-report']['effective-directive'] : 'unknown',
        isset($report['csp-report']['blocked-uri']) ? $report['csp-report']['blocked-uri'] : 'unknown',
        isset($report['csp-report']['document-uri']) ? $report['csp-report']['document-uri'] : 'unknown',
        isset($report['csp-report']['violated-directive']) ? $report['csp-report']['violated-directive'] : 'unknown',
        isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'unknown'
    );
    
    // 写入日志文件
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

// 处理报告
if (isset($report_data['csp-report'])) {
    // 记录违规
    log_csp_violation($report_data);
    
    // 返回成功响应
    echo json_encode(array('status' => 'success', 'message' => 'CSP violation logged'));
} else {
    // 无效的报告格式
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Invalid CSP report format'));
}
?>