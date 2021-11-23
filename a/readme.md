
说明
===


# Controller

```
class IndexController extends Controller {
    public function index() {}
}
```

## request

```
        $get  = $this->request->get();
        $post = $this->request->post();
```

## response

```
        $this->response->json($res);
```

## session
        $this->session->set('user', 'chidatianoooo');
        $this->session->get(),
        $this->session->get('user'),


# Model

```
class Members extends Model {
	protected $dbName = 'tmp'; // Labrary 注册的数据库名
	protected $tableName = 'members'; // 表名
}
```

### SELECT

```
(new Members)->findFirst([
        'columns' => 'id,user',
        'conditions' => 'id = :id',
        'bind' => [
            'id' => 2
        ],
        'group' => '',
        'order' => 'user',
        'limit' => $page->limit(),
    ]);
```

### INSERT

```
(new Members)->create([
            'user' => 'ddd edit'
        ]);
```

### UPDATE

```
(new Members)->update([
            'user' => 'ddd edit'
        ],[
            'id' => 4
        ]);
```

### DELETE

### SQL

```
@return $stmt PDOStatement
$stmt = (new Members)->prepare($sql, $bind);


$res = $stmt->fetchAll(2);
```