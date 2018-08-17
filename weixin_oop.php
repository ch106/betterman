<?php
	class WeixinApi{
		private $appid;
		private $appsecret;
		public function __construct($id="",$secret=""){
			$this->appid=$id;
			$this->appsecret=$secret;
		}
		//验证消息方法
		public function valid()
		{
			if($this->checkSignature())
			{

				return $_GET['echostr'];//返回echostr随机字符串
			}
			else
			{
				return "";
			}
		}

		//检验微信加密签名的方法
		private function checkSignature()
		{
				
			//一、接收微信服务器GET提交过来的参数
			$signature 	= $_GET['signature'];  	//微信加密签名
			$timestamp 	= $_GET['timestamp'];  	//时间戳
			$nonce 		= $_GET['nonce'];  		//随机数

			//二、验证服务器地址的有效性
			
			//1、加密/校验流程如下：
			// 将 token、timestamp、nonce 三个参数进行字典序排序。

			$tempArr = array($timestamp,TOKEN,$nonce);

			sort($tempArr,SORT_STRING);
			
			// 将以上三个参数拼接成一个字符串进行 sha1 加密。
			
			$tempStr = implode($tempArr);

			$signatureStr = sha1($tempStr);

			// 将加密后的字符串与 signature 对比。
			
			// 2、经过加密/校验后，若确认此次 GET 请求来自微信服务器，请原样返回 echostr 参数内容，则接入生效，成为开发者成功，否则接入失败。
			if($signatureStr == $signature)
			{
				return true;//如果校对成功，就返回true
			}
			else
			{
				return false;//如果校对失败，就返回false
			}			
		}

		//响应消息
		public function responseMsg()
		{
			//1、接收 XML 数据包
			//$HTTP_RAW_POST_DATA  包含 POST 提交的原始数据。
			//注意：此时 $HTTP_RAW_POST_DATA  需要换成$GLOBALS[HTTP_RAW_POST_DATA]。

			$postData = $GLOBALS[HTTP_RAW_POST_DATA];

			//2、处理 XML 数据包
			//simplexml_load_string( )  该函数可以解析XML。
			$postObj = simplexml_load_string($postData,"SimpleXMLElement",LIBXML_NOCDATA);

			$ToUserName 	= $postObj->ToUserName;		//开发者微信号
			$FromUserName 	= $postObj->FromUserName;	//发送方帐号（一个OpenID）
			$MsgType		= $postObj->MsgType;		//消息类型
			$Content		= $postObj->Content;		//文本消息内容

			//被动回复消息
			switch($MsgType)
			{
				
				case 'text':
					return $this->receiveText($postObj);
					break;
				case 'image':
					return $this->receiveImage($postObj);
					break;
				case 'voice':
					return $this->receiveVoice($postObj);
					break;
				case 'video':
					return $this->receiveVideo($postObj);
					break;
				case 'music':
					return $this->receiveMusic($postObj);
					break;
				case 'event':
					return $this->replyEvent($postObj);
					break;

			}
		}
		public function receiveText($obj){
				$Content= $obj->Content;
				$key="198d928767884fa9a67fe71af8d1d710";
				$url="http://www.tuling123.com/openapi/api?info={$Content}&key={$key}&userid=1234";
				$arr=$this->https_request($url);
					switch($arr['code']){
						case '100000':
							return $this->replyText($obj,$arr['text']);
							break;
						case '200000':
							return $this->replyText($obj,$arr['text'].','.$arr['url']);
							break;
						case '302000':
							$result=array();
							foreach ($arr['list'] as $value) {
									$root[]=array(
											'Title' => $value['article'], 
											'Description' => $value['source'], 
											'PicUrl' =>$value['icon'],
											'Url' => $value['detailurl']
											);
									}
								$result=array_rand($root,3);
								foreach($result as $value){
								$list[]=$root[$value];
								}
								return $this->replyNews($obj,$list);
								break;
						case '308000':
							$result=array();
							foreach ($arr['list'] as $value) {
									$root[]=array(
											'Title' => $value['name'], 
											'Description' => $value['info'], 
											'PicUrl' =>$value['icon'],
											'Url' => $value['detailurl']
											);
									}
								$result=array_rand($root,3);
								foreach($result as $value){
								$list[]=$root[$value];
								}
								return $this->replyNews($obj,$list);
								break;
					}
		}		
		public function receiveImage($obj){
				$PicUrl	=$obj->PicUrl;
				$MediaId=$obj->MediaId;
				return $this->replyImage($obj,$MediaId);
		}
		public function receiveVoice($obj){
				$MediaId=$obj->MediaId;
				$Recognition=$obj->Recognition;
				if(isset($obj->Recognition)){
					if($Recognition==""){
						return $this->replyText($obj,'请说话');
					}
					return $this->replyText($obj,$Recognition);
				}
				else{
					return $this->replyVoice($obj,$MediaId);
				}
				
		}
		public function receiveVideo($obj){
				$MediaId=$obj->MediaId;
				$ThumbMediaId=$obj->ThumbMediaId;
				return $this->replyVideo($obj,$MediaId);
		}
		public function replyText($obj,$content){
			$replyText = "<xml> 
								<ToUserName><![CDATA[%s]]></ToUserName> 
								<FromUserName><![CDATA[%s]]></FromUserName> 
								<CreateTime>%d</CreateTime> 
								<MsgType><![CDATA[text]]></MsgType>
								<Content><![CDATA[%s]]></Content> 
						  </xml>";
			return sprintf($replyText,$obj->FromUserName,$obj->ToUserName,time(),$content);
		}
		public function replyImage($obj,$id){
			
			$replyImage = "<xml> 
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%d</CreateTime>
								<MsgType><![CDATA[image]]></MsgType>
								<Image>
									<MediaId><![CDATA[%s]]></MediaId>
								</Image>
						  </xml>";
			return sprintf($replyImage,$obj->FromUserName,$obj->ToUserName,time(),$id);
		}
		public function replyVoice($obj,$mediaId,$Recognition){
			$replyVoice="<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%d</CreateTime>
								<MsgType><![CDATA[voice]]></MsgType>
								<Voice>
									<MediaId><![CDATA[%s]]></MediaId>
								</Voice>
							</xml>";
			return sprintf($replyVoice,$obj->FromUserName,$obj->ToUserName,time(),$mediaId,$Recognition);
		}
		public function replyVideo($obj,$mediaId){
			$replyVideo="<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%d</CreateTime>
								<MsgType><![CDATA[video]]></MsgType>
								<Video>
									<MediaId><![CDATA[%s]]></MediaId>
									<Title><![CDATA[video]]></Title>
									<Description><![CDATA[video]]></Description>
								</Video>
							</xml>";
			return sprintf($replyVideo,$obj->FromUserName,$obj->ToUserName,time(),$mediaId);
		}
		public function replyMusic($obj){
			$replyMusic="<xml>  
				                <ToUserName><![CDATA[%s]]></ToUserName>  
				            	<FromUserName><![CDATA[%s]]></FromUserName>  
				                <CreateTime>%s</CreateTime>  
				                <MsgType><![CDATA[music]]></MsgType>  
				                <Music>  
				                    <Title><![CDATA[凉城]]></Title>  
				                    <Description><![CDATA[演唱：任然]]></Description>  
				                    <MusicUrl><![CDATA[http://bd.kuwo.cn/yinyue/11713653?from=dq360]]></MusicUrl>  
				                    <HQMusicUrl><![CDATA[http://bd.kuwo.cn/yinyue/11713653?from=dq360]]></HQMusicUrl>
				                </Music>  
			                </xml>";
			return sprintf($replyMusic,$obj->FromUserName,$obj->ToUserName,time());
		}
		public function replyNews($obj,$itemArr){  //图文
			$result="";
			foreach($itemArr as $v){
				$item="<item>
							<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
							<Url><![CDATA[%s]]></Url>
						</item>";
				$result.=sprintf($item,$v['Title'],$v['Description'],$v['PicUrl'],$v['Url']);
				
			}
			$replyNews="<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%d</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>%s</ArticleCount>
							<Articles>{$result}</Articles>
						</xml>";
			return sprintf($replyNews,$obj->FromUserName,$obj->ToUserName,time(),count($itemArr));
		}
		public function replyEvent($obj){
				$event=$obj->Event;
				switch($event){
					case 'subscribe':
						$result="http://punchdrunker.github.io/iOSEmoji/table_html/bells/bells_10_05.png";
						$text="你好，欢迎关注";
						return $this->replyText($obj,$text);
						break;
					case 'CLICK':
						$EventKey=$obj->EventKey;
						switch($EventKey){
							case 'SERVICE':
								return $this->replyText($obj,"电话:15735659969");
								break;
							// case 'INFORMATION':
							// 	return $this->weixin_choice($obj);
							// 	break;
							case 'INFORMATION':
								$key = "dbbb10e5900358b394bef0508d816211";
								$time = time();
								$jokeUrl = "http://v.juhe.cn/joke/randJoke.php?key={$key}&time={$time}&pagesize=1";

								$jokeArr = $this->https_request($jokeUrl);

								if($jokeArr['error_code']==0)
								{
									$jokeContent = $jokeArr['result'][0]['content'];

									return $this->replyText($obj,$jokeContent);
								}
						
							}
					}	
				}
		public function menu_create($data)
		{
			//自定义菜单创建接口地址
			$access_token = $this->getAccessToken();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
			return $this->https_request($url,$data);
		}


		//自定义菜单查询
		public function menu_select()
		{
			//自定义菜单查询接口地址
			$access_token = $this->getAccessToken();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";
			return $this->https_request($url);
		}

		//自定义菜单删除
		public function menu_delete()
		{
			//自定义菜单删除接口地址
			$access_token = $this->getAccessToken();
			$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$access_token}";
			return $this->https_request($url);
		}
		public function getAccessToken(){
			$access_token=$this->memcached_get('access_token');
			if(!$access_token){
				$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
				$jsonArr=$this->https_request($url);
				$this->memcached_set('access_token',$jsonArr['access_token'],7200);
				return $jsonArr['access_token'];
			}
			return $access_token;
		}
			
		public function memcache(){
			$mmc=new Memcached();
			return $mmc;
		}
		public function memcached_set($key,$value,$time=0){
			$mmc=$this->memcache();
			$mmc->set($key,$value,$time);

		}
		public function memcached_get($key){
			$mmc=$this->memcache();
			return $mmc->get($key);
		}
		public function https_request($url,$data=null){
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
			if(!empty($data)){
				curl_setopt($ch,CURLOPT_POST,1);
				curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
			}
			$outopt=curl_exec($ch);
			curl_close($ch);
			$outoptArr = json_decode($outopt,true);

			if(is_array($outoptArr))
			{
				return $outoptArr;
			}
			else
			{
				return $outopt;
			}
		
		}
		public function snsapi_base($redirect_uri){
			// 第一步：引导用户进入授权页面同意授权，获取 code；
			$snsapi_base_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=321#wechat_redirect";

			// 如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=123。
			
			if(!isset($_GET['code']))
			{
				header("Location:{$snsapi_base_url}");
			}


			$code = $_GET['code'];
			// 第二步：通过 code 换取网页授权 access_token（与基础支持中的 access_token 不同）和 openid；
			$access_token_url ="https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appid}&secret={$this->appsecret}&code={$code}&grant_type=authorization_code";

			return $this->https_request($access_token_url);
		}
		public function snsapi_userinfo($redirect_uri){
			// 第一步：引导用户进入授权页面同意授权，获取 code；
			$snsapi_userinfo_url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=321#wechat_redirect";

			// 如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=123。
			
			if(!isset($_GET['code']))
			{
				header("Location:{$snsapi_userinfo_url}");
			}


			$code = $_GET['code'];


			// 第二步：通过 code 换取网页授权 access_token（与基础支持中的 access_token 不同）和 openid；
			$access_token_url ="https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appid}&secret={$this->appsecret}&code={$code}&grant_type=authorization_code";

			$result=$this->https_request($access_token_url);
			$access_token=$result['access_token'];
			$openid=$result['openid'];
			//第三步：刷新网页授权access_token，避免过期
			//第四步：通过网页授权access_token和openID获取用户基本信息
			$userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
			return $this->https_request($userinfo_url);
			}
	}
?>