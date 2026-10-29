<?php

require_once __DIR__ . '/../models/ActionsModel.php';

class Actions
{
    private $model;
    private $load;

    public function __construct()
    {
        Auth::requireLogin();
        $this->model = new ActionsModel();
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
        $totalActions = (int) $this->model->countActions($search);
        $totalPages = max(1, (int) ceil($totalActions / $perPage));
        $pageInput = $_GET['page'] ?? 1;
        $requestedPage = is_scalar($pageInput) ? filter_var($pageInput, FILTER_VALIDATE_INT) : false;
        $page = ($requestedPage === false || $requestedPage < 1) ? 1 : (int) $requestedPage;
        $actions = $this->model->getActions(
            $search,
            $perPage,
            ($page - 1) * $perPage
        );

        $this->load->view('views/actions/index.php', [
            'actions'      => $actions,
            'search'       => $search,
            'page'         => $page,
            'perPage'      => $perPage,
            'totalPages'   => $totalPages,
            'totalActions' => $totalActions,
        ]);
    }

    public function create()
    {
        $isEdit = false;
        $this->load->view('views/actions/form.php', [
            'isEdit' => $isEdit,
        ]);
    }

    public function store()
    {
        $errors = $this->validate($_POST);

        if (!empty($errors)) {
            $isEdit = false;
            $this->load->view('views/actions/form.php', [
                'isEdit' => $isEdit,
                'actions' => $_POST,
                'errors' => $errors,
            ]);
            return;
        }

        $this->model->createAction([
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description']),
        ]);

        header('Location: ' . BASE_URL . '/actions');
        exit;
    }

    public function edit($id)
    {
        $actions = $this->model->getActionById($id);

        if ($actions === null) {
            http_response_code(404);
            echo '404 - Actions not found';
            return;
        }

        $isEdit = true;
        $this->load->view('views/actions/form.php', [
            'isEdit'    => $isEdit,
            'id'        => $id,
            'actions' => $actions,
        ]);
    }

    public function update($id)
    {
        if ($this->model->getActionById($id) === null) {
            http_response_code(404);
            echo '404 - Actions not found';
            return;
        }

        $errors = $this->validate($_POST);

        if (!empty($errors)) {
            $isEdit = true;
            $actions = $this->model->getActionById($id);
            $this->load->view('views/actions/form.php', [
                'isEdit'    => $isEdit,
                'id'        => $id,
                'actions' => array_merge($actions, $_POST),
                'errors'    => $errors,
            ]);
            return;
        }

        $this->model->updateAction($id, [
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description']),
        ]);

        header('Location: ' . BASE_URL . '/actions');
        exit;
    }

    public function delete($id)
    {
        if ($this->model->getActionById($id) === null) {
            http_response_code(404);
            echo '404 - Actions not found';
            return;
        }

        $this->model->deleteAction($id);
        header('Location: ' . BASE_URL . '/actions');
        exit;
    }
}
