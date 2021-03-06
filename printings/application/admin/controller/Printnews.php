<?php
namespace app\admin\controller;

use app\common\model\Printnews as UserModel;
use app\common\model\Category as CategoryModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 时事新闻管理
 * Class Printnews
 * @package app\admin\controller
 */
class Printnews extends AdminBase
{

    protected $printnews_model;
    protected $category_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->printnews_model = new UserModel();
        $this->category_model = new CategoryModel();
        $category_level_list = $this->category_model->getLevelList();
        $this->assign('category_level_list', $category_level_list);
    }

    /**
     * 时事新闻管理
     * @return mixed
     */
    public function index($cid = 0, $keyword = '', $page = 1)
    {
        $map   = [];
        $field = 'id,title,cid,author,reading,status,publish_time,update_time,sort';
        if ($cid > 0) {
            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }

        if (!empty($keyword)) {
            $map['title'] = ['like', "%{$keyword}%"];
        }

        $article_list  = $this->printnews_model->field($field)->where($map)->order(['publish_time' => 'DESC'])->paginate(15, false, ['page' => $page]);
        $category_list = $this->category_model->column('name', 'id');

        return $this->fetch('index', ['printnews_list' => $article_list, 'category_list' => $category_list, 'cid' => $cid, 'keyword' => $keyword]);
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
     * 保存时事新闻
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $data['create_time']    = date('Y-m-d H:i:s',time());
            $printnews_result = $this->validate($data, 'Printnews');

            if ($printnews_result !== true) {
                $this->error($printnews_result);
            } else {
                if ($this->printnews_model->allowField(true)->save($data)) {
                    $this->success('保存成功','index');
                } else {
                    $this->error('保存失败');
                }
            }
        }
        return $this->fetch('index');
    }
    /**
     * 编辑时事新闻
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $printnews = $this->printnews_model->find($id);

        return $this->fetch('edit', ['printnews' => $printnews]);
    }
    /**
     * 更新时事新闻
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data                   = $this->request->param();
            $data['update_time']    = date('Y-m-d H:i:s',time());
            $validate_result = $this->validate($data, 'Printnews');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->printnews_model->allowField(true)->save($data, $id) !== false) {
                    $this->success('更新成功','index');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除新闻
     * @param int   $id
     * @param array $ids
     */
    public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->printnews_model->destroy($id)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的时事新闻');
        }
    }
    /**
     * 新闻审核状态切换
     * @param array  $ids
     * @param string $type 操作类型
     */
    public function toggle($ids = [], $type = '')
    {
        $data   = [];
        $status = $type == 'audit' ? 1 : 0;

        if (!empty($ids)) {
            foreach ($ids as $value) {
                $data[] = ['id' => $value, 'status' => $status];
            }
            if ($this->printnews_model->saveAll($data)) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->error('请选择需要操作的文章新闻');
        }
    }



}