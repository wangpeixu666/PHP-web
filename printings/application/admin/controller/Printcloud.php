<?php
namespace app\admin\controller;

use app\common\model\Printcloud as UserModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 云端存储
 * Class Printcloud
 * @package app\admin\controller
 */
class Printcloud extends AdminBase
{
    protected $printcloud_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->printcloud_model = new UserModel();
    }
    /**
     * 云端存储
     * @return mixed
     */
    public function index($page = 1)
    {

        $printgroup_list = Db::table('os_printcloud')
            ->order('id DESC')
            ->paginate(5, false, ['page' => $page]);
        return $this->fetch('index', ['printcloud_list' => $printgroup_list]);

    }

    /**
     * 添加
     * @param $id
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }
    /**
     * 保存内容
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data                   = $this->request->param();
            $data['create_time']    = date('Y-m-d H:i:s',time());
            $printcloud_result = $this->validate($data, 'Printcloud');
            if ($printcloud_result !== true) {
                $this->error($printcloud_result);
            } else {
                if ($this->printcloud_model->allowField(true)->save($data)) {
                    $this->success('保存成功','index');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑集团动态
     */
    public function edit($id)
    {
        $printcloud= $this->printcloud_model->find($id);

        return $this->fetch('edit', ['printcloud' => $printcloud]);
    }

    /**
     * 更新公司简介
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $data['update_time']    = date('Y-m-d H:i:s',time());
            $validate_result = $this->validate($data, 'Printcloud');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->printcloud_model->allowField(true)->save($data, $id) !== false) {
                    $this->success('更新成功','index');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除公司简介（一般是不能删除只进行修改编辑）
     * @param int   $id
     * @param array $ids
     */
/*    public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->Printcompany_model->destroy($id)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的公司简介');
        }
    }*/




}