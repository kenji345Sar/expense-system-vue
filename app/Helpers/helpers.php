<?php

if (!function_exists('expense_status_label')) {
  function expense_status_label(?string $status): string
  {
    return [
      'draft' => '下書き',
      'submitted' => '申請中',
      'approved' => '承認済',
    ][$status] ?? '未連携';
  }
}
