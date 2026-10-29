<?php

require_once __DIR__ . '/../models/AccountsModel.php';
require_once __DIR__ . '/../models/AccountTypeModel.php';

class Accounts
{
    private $model;
    private $accountTypeModel;
    private $load;

    public function __construct()
    {
        Auth::requireLogin();
        $this->model = new AccountsModel();
        $this->accountTypeModel = new AccountTypeModel();
        $this->load = new Loader();
    }

    private function validate($data, $isEdit = false, $id = null)
    {
        $errors = [];

        if (trim($data['name'] ?? '') === '') {
            $errors['name'] = 'Name is required.';
        }

        $email = trim($data['email'] ?? '');
        if ($email === '') {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email format is invalid.';
        } elseif ($this->model->emailExists($email, $id)) {
            $errors['email'] = 'Email is already registered.';
        }

        if (!$isEdit && trim($data['password'] ?? '') === '') {
            $errors['password'] = 'Password is required.';
        } elseif (
            trim($data['password'] ?? '') !== ''
            && strlen($data['password']) < 6
        ) {
            $errors['password'] = 'Password must be at least 6 characters.';
        }

        if (trim($data['account_type_id'] ?? '') === '') {
            $errors['account_type_id'] = 'Account type is required.';
        } elseif ($this->accountTypeModel->getAccountTypeById($data['account_type_id']) === null) {
            $errors['account_type_id'] = 'Selected account type is invalid.';
        }

        if (!in_array($data['status'] ?? '', ['aktif', 'nonaktif'], true)) {
            $errors['status'] = 'Status must be active or inactive.';
        }

        if (trim($data['identification_number'] ?? '') === '') {
            $errors['identification_number'] = 'Identification number is required.';
        }

        if (!in_array($data['identification_type'] ?? '', ['nim', 'nip'], true)) {
            $errors['identification_type'] = 'Identification type is invalid.';
        }

        $username = trim($data['username'] ?? '');
        if ($username === '') {
            $errors['username'] = 'Username is required.';
        } elseif ($this->model->usernameExists($username, $id)) {
            $errors['username'] = 'Username already registered.';
        }

        return $errors;
    }

    private function formData($account = null, $errors = [])
    {
        return [
            'isEdit' => $account !== null,
            'id' => $account['id'] ?? null,
            'account' => $account,
            'accountTypes' => $this->accountTypeModel->getAccountType(),
            'errors' => $errors,
        ];
    }

        public function index()
    {
        $searchInput = $_GET['q'] ?? '';
        $search = is_string($searchInput) ? trim($searchInput) : '';

        $perPage = 5;
        $totalAccounts = (int) $this->model->countAccounts($search);

        $totalPages = max(1, (int) ceil($totalAccounts / $perPage));

        $pageInput = $_GET['page'] ?? 1;
        $requestedPage = is_scalar($pageInput) ? filter_var($pageInput, FILTER_VALIDATE_INT) : false;
        $page = ($requestedPage === false || $requestedPage < 1) ? 1 : (int) $requestedPage;
        $page = min($page, $totalPages);

        $accounts = $this->model->getAccounts(
            $search,
            $perPage,
            ($page - 1) * $perPage
        );

        $this->load->view('views/accounts/index.php', [
            'accounts'      => $accounts,
            'search'        => $search,
            'page'          => $page,
            'perPage'       => $perPage,
            'totalPages'    => $totalPages,
            'totalAccounts' => $totalAccounts,
        ]);
    }

    public function create()
    {
        $this->load->view('views/accounts/form.php', $this->formData());
    }

    public function store()
    {
        $errors = $this->validate($_POST);
        if (!empty($errors)) {
            $this->load->view('views/accounts/form.php', [
                'isEdit' => false,
                'account' => $_POST,
                'accountTypes' => $this->accountTypeModel->getAccountType(),
                'errors' => $errors,
            ]);
            return;
        }

        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $this->model->createAccount($_POST);

        header('Location: ' . BASE_URL . '/accounts');
        exit;
    }

    public function edit($id)
    {
        $account = $this->model->getAccountById($id);
        if ($account === null) {
            http_response_code(404);
            echo '404 - Account not found';
            return;
        }

        $this->load->view('views/accounts/form.php', $this->formData($account));
    }

    public function update($id)
    {
        $account = $this->model->getAccountById($id);
        if ($account === null) {
            http_response_code(404);
            echo '404 - Account not found';
            return;
        }

        $errors = $this->validate($_POST, true, $id);
        if (!empty($errors)) {
            $this->load->view('views/accounts/form.php', [
                'isEdit' => true,
                'id' => $id,
                'account' => array_merge($account, $_POST),
                'accountTypes' => $this->accountTypeModel->getAccountType(),
                'username' => $_POST['username'] ?? '',
                'errors' => $errors,
            ]);
            return;
        }

        if (!empty($_POST['password'])) {
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $this->model->updateAccount($id, $_POST);

        header('Location: ' . BASE_URL . '/accounts');
        exit;
    }

    public function delete($id)
    {
        $account = $this->model->getAccountById($id);
        if ($account === null) {
            http_response_code(404);
            echo '404 - Account not found';
            return;
        }

        $this->model->deleteAccount($id);

        header('Location: ' . BASE_URL . '/accounts');
        exit;
    }
}
