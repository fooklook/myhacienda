<?php namespace App\Console\Commands;

use App\Album;
use App\AlbumImage;
use App\Article;
use App\ArticleClassify;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LeadMarkdownCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'lead:markdown';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '��markdown�ļ�����ת����html�����洢�����ݿ��С�';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/** �û���Ϣ **/
	private $user;
	/** ���ñ������ӵ�����id���� **/
	private $wait_article = array();

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire(){
		header("Content-type: text/html; charset=utf-8");
		//����Ա��¼
		$this->user = $this->login();
		//��Ҫ������Ŀ¼
		$path = 'D:/laravel/laravelnote';
		//�Ӹ�Ŀ¼��README�ļ�������࣬����ȡĿ¼�����֮��Ķ�Ӧ��ϵ��
		$path_array = $this->classify($path . '/' .'README.md');
		//����
		foreach($path_array as $key=>$value){
			echo "��ʼ����{$value}Ŀ¼����\r\n";
			$this->ergodic($key, $path . '/' . $value);
		}
	}

	/** ������Ŀ¼�µ�README�ļ���������������Ϣ **/
	public function classify($Path){
		echo "��ʼ�������ࣺ\r\n";
		DB::table('article_classify')->truncate();
		$file = fopen($Path, "r") or exit('��ȡ�����ļ�ʧ��');
		$classify_path = array();
		while(!feof($file)){
			//��ȡ��������
			$conn = fgets($file);
			$pattern = '/##(.*)-(.*)/i';
			preg_match($pattern,$conn,$conn_pattern);
			$name = $conn_pattern[1];
			//��ȡ��������
			$describe = fgets($file);
			$classify = new ArticleClassify();
			$classify->article_classify_name = $name;
			$classify->article_classify_describe = $describe;
			$classify->article_classify_trunk_id = 1;
			$classify->created_at = \Carbon\Carbon::now();
			$classify->save();
			$classify_path[$classify->article_classify_id] = $conn_pattern[2];
		}
		fclose($file);
		echo "�������ɹ���\r\n";
		//����Ŀ¼
		return $classify_path;
	}

	/** ����Ŀ¼�µ����� **/
	private function ergodic($article_classify_id, $Path){
		$handle = opendir($Path);
		while(($file = readdir($handle)) !== false){
			if($file == '.' ||  $file == '..' || $file == 'README.md'){
				continue;
			}
			if($file == "images"){
				$this->update_qiniu($Path . '/' . 'images');
				continue;
			}
			//��md�ļ�д�����ݿ�
			$this->md2db($article_classify_id, $Path . '/' . $file);
		}
		closedir($handle);
	}

	/** �ϴ���ţͼƬ **/
	private function update_qiniu($Path){
		echo "���ָ�Ŀ¼�´���ͼƬ���ϴ�����ţ��������...\r\n";
		$exist_num = 0;
		$upload_num = 0;
		$user = $this->user;
		$handle = opendir($Path);
		if($handle){
			while(($file=readdir($handle)) !== false){
				if($file == "." || $file == ".."){
					continue;
				}
				$file_name = $Path . '/' .$file;
				//��ͼƬ�ϴ�����ţ��������
				$disk = \Storage::disk('qiniu');
				$qiniu_image_src = $this->qiniu_imgname($file_name);
				//���ͼƬ���ڣ���������
				if($disk->exists($qiniu_image_src)){
					$exist_num++;
					continue;
				}
				$upload_num++;
				$contents = file_get_contents($file_name);

				if($disk->put($qiniu_image_src, $contents)){
					echo $file_name . "�ϴ��ɹ�\r\n";
				}
				//����ţͼƬ��ַд�����ݿ���
				$album = Album::default_album($user);
				$image = new AlbumImage();
				$image->album_id = $album->album_id;
				$image->image_src = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' .$qiniu_image_src;
				$image->image_type = pathinfo($file_name)['extension'];
				$image->created_at = \Carbon\Carbon::now();
				$image->save();
			}
			closedir($handle);
		}
		$total_num = $exist_num + $upload_num;
		echo "����ϴ������ϴ�{$upload_num}��ͼƬ����Ŀ¼�����Ϲ�{$total_num}��ͼƬ\r\n";
	}

	/** �ϴ�����ţ��ͼƬ���������� **/
	private function qiniu_imgname($file_name){
		$path_info = pathinfo($file_name);
		$explode = explode('/',$path_info['dirname']);
		//ͼƬ����Ŀ¼
		$path = $explode[count($explode)-2];
		return 'fk_' . $path . '_' . md5($path_info['basename']) . '.' . $path_info['extension'];
	}

	/** �û���¼ **/
	private function login(){
		do{
			$name = $this->ask("Login username��");
			$password = $this->secret("{$name}'s password��");
			$user = User::with('adminuser')->where('user_name','=',$name)->get();
			if(count($user)==0 || $user[0]->user_password != md5($password)){
				echo "Permission denied, please try again.\r\n";
			}else {
				if ($user[0]->adminuser->user_power == 7) {
					break;
				} else {
					echo "Not enough permissions.";
				}
			}
		}while(true);
		//�û���Ϣ
		return $user[0];
	}

	/** ��md������д�뵽���ݿ��� **/
	private function md2db($article_classify_id , $file_name){
		echo "��ʼ����{$file_name}==========>";
		$file_array = pathinfo($file_name);
		//��ȡ���±���
		$file = fopen($file_name, "r") or exit('��ȡ�����ļ�ʧ��');
		$title = fgets($file);
		$title = str_replace('#','',$title);
		fclose($file);
		$file_conn = file_get_contents($file_name);
		//ƥ���Ƿ��������ͼƬ
		$pattern = '/\((\.\/images\/.*)\)/isU';
		preg_match_all($pattern,$file_conn,$match);
		if(count($match[1]) > 0) {
			$replace = array();
			foreach ($match[1] as $value) {
				$tmp = explode("/", $value);
				$file_array['dirname'] . '/images/' . $tmp[(count($tmp) - 1)];
				$replace[] = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' . $this->qiniu_imgname($file_array['dirname'] . 'images' . $tmp[(count($tmp) - 1)]);
			}
			$file_conn = str_replace($match[1], $replace, $file_conn);
		}

		$article = new Article();
		$article->conn_type_id = 2;
		$article->user_id = 1;
		$article->article_classify_id = $article_classify_id;
		$article->article_title = $title;
		$article->article_digest = "";
		$article->article_cover = "";
		$article->article_content = $file_conn;
		$article->article_from = "fooklook";
		$article->article_status = 1;
		$article->created_at = filectime($file_name);
		$article->updated_at = filemtime($file_name);
		$article->save();
		echo "����ɹ���\r\n";
	}
}
