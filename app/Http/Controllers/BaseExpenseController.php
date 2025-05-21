<?php

namespace App\Http\Controllers;


use App\Services\ExpenseService;


abstract class BaseExpenseController extends Controller
{

  protected string $expenseType;
  protected string $modelClass;
  protected string $routeName;

  protected ExpenseService $expenseService;

  public function __construct(ExpenseService $expenseService)
  {
    $this->expenseService = $expenseService;
  }

  protected function buildFormView(string $configKey, string $title, string $formTitle, string $formAction, string $backUrl, array $details = [], bool $isEdit = false)
  {
    $allFields = config("expense_headers.$configKey");
    $formFields = array_values(array_filter($allFields, function ($field) {
      return !in_array($field['key'], ['id', 'user.name']);
    }));

    return view('expenses.form', [
      'details'    => $details,
      'pageTitle'  => $title,
      'formTitle'  => $formTitle,
      'formAction' => $formAction,
      'backUrl'    => $backUrl,
      'isEdit'     => $isEdit,
      'fields'     => $formFields,
    ]);
  }

  public function updateValidated(array $validated, $id)
  {
    $this->expenseService->update(
      $validated,
      $this->expenseType,
      $this->modelClass,
      $id
    );

    return redirect()
      ->route($this->routeName)
      ->with('success', '更新が完了しました！');
  }
}
