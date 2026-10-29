<?php

require_once __DIR__ . '/../models/AccountTypeModel.php';

class AccountType
{
    private $model;
    private $load;

    public function __construct()
    {
        Auth::requireLogin();
        $this->model = new AccountTypeModel();
        $this->load  = new Loader();
    }

    private function validate($data)
    {
        $errors = [];

        if (empty(trim($data['name'] ?? ''))) {
            $errors['name'] = 'Name is required.';
        }

        if (empty(trim($data['description'] ?? ''))) {
            $errors['description'] = 'Description is required.';
        }

        return $errors;
    }

    public function index()
    {
        $searchInput = $_GET['q'] ?? '';
        $search = is_string($searchInput) ? trim($searchInput) : '';
        $perPage = 5;
        $totalAccountTypes = (int) $this->model->countAccountTypes($search);
        $totalPages = max(1, (int) ceil($totalAccountTypes / $perPage));
        $pageInput = $_GET['page'] ?? 1;
        $requestedPage = is_scalar($pageInput) ? filter_var($pageInput, FILTER_VALIDATE_INT) : false;
        $page = ($requestedPage === false || $requestedPage < 1) ? 1 : (int) $requestedPage;
        $accounttype = $this->model->getAccountType($search, $perPage, ($page - 1) * $perPage);

        $this->load->view('views/accounttype/index.php', [
            'accounttype'       => $accounttype,
            'search'            => $search,
            'page'              => $page,
            'perPage'           => $perPage,
            'totalPages'        => $totalPages,
            'totalAccountTypes' => $totalAccountTypes,
        ]);
    }

    public function create()
    {
        $isEdit = false;
        $this->load->view('views/accounttype/form.php', [
            'isEdit' => $isEdit,
        ]);
    }

    public function store()
    {
        $errors = $this->validate($_POST);

        if (!empty($errors)) {
            $isEdit = false;
            $this->load->view('views/accounttype/form.php', [
                'isEdit' => $isEdit,
                'accounttype' => $_POST,
                'errors' => $errors,
            ]);
            return;
        }

        $this->model->createAccountType([
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description']),
        ]);

        header('Location: ' . BASE_URL . '/account-type');
        exit;
    }

    public function edit($id)
    {
        $accounttype = $this->model->getAccountTypeById($id);

        if ($accounttype === null) {
            http_response_code(404);
            echo '404 - accounttype not found';
            return;
        }

        $isEdit = true;
        $this->load->view('views/accounttype/form.php', [
            'isEdit'    => $isEdit,
            'id'        => $id,
            'accounttype' => $accounttype,
        ]);
    }

    public function update($id)
    {
        $accounttype = $this->model->getAccountTypeById($id);
        if ($accounttype === null) {
            http_response_code(404);
            echo '404 - accounttype not found';
            return;
        }

        $errors = $this->validate($_POST);

        if (!empty($errors)) {
            $isEdit = true;
            $this->load->view('views/accounttype/form.php', [
                'isEdit'    => $isEdit,
                'id'        => $id,
                'accounttype' => array_merge($accounttype, $_POST),
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->updateAccountType($id, [
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description']),
        ]);

        header('Location: ' . BASE_URL . '/account-type');
        exit;
    }

    public function delete($id)
    {
        $accounttype = $this->model->getAccountTypeById($id);
        if ($accounttype === null) {
            http_response_code(404);
            echo '404 - accounttype not found';
            return;
        }

        $this->model->deleteAccountType($id);

        header('Location: ' . BASE_URL . '/account-type');
        exit;
    }
}
