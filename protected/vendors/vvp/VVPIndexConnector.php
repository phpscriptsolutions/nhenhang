<?php
class VVPIndexConnector {
	/**
	 *
	 * @var array params
	 *	- storatehost
	 *	- storagekey
	 *	- streaminghost
	 */
	public $params = null;

    public function __construct($params) {
        if($params) $this->params = $params;
    }

    /**
     * Tao moi mot bucket
     */
    public function createBucket($bucketName, $meta='',$location = 'vvp_storage', $user, $pass)
    {

        $url = $this->params['storagehost'].'buckets?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $body = '<bucket>
                    <bucketName>'.$bucketName.'</bucketName>
                    <location>/'.$location.'/</location>
                    <metadata>'.$meta.'</metadata>
                </bucket>';

        $ch = curl_init(); // initialize curl handle
        curl_setopt($ch, CURLOPT_VERBOSE, 1); // set url to post to
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body); // add POST fields
        curl_setopt($ch, CURLOPT_POST, 1);

        $result = curl_exec($ch); // run the whole process
        curl_close($ch);

        return $result;
    }

    /**
     * Lay thong tin tat ca bucket cua mot user
     */
    public function getAllBucketInfo($user, $pass)
    {
        $url = $this->params['storagehost'].'buckets?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Lay thong tin cua mot bucket
     */
    public function getBucketInfo($bucketName, $user, $pass)
    {

        $url = $this->params['storagehost'].'buckets/search?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&vvp-di-bucket-bucketname='.$bucketName;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Xoa mot mot bucket
     */
    public function deleteBucket($bucketId, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;

        //return resonpse header, check header if httpResponse 200 OK
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    /**
     * Xoa tat ca bucket cua mot user
     */
    public function deleteAllBucketInfo($user, $pass)
    {
        $url = $this->params['storagehost'].'buckets?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;

        //return resonpse header, check header if httpResponse 200 OK
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);

    }

    /**
     * cap nhat thong tin cua mot bucket
     */
    public function updateBucket($bucketId, $bucketName, $meta='', $user, $pass)
    {

        $url = $this->params['storagehost'].'buckets/'.$bucketId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $body = '<bucket>
                    <bucketName>'.$bucketName.'</bucketName>
                    <metadata>'.$meta.'</metadata>
                </bucket>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_POST, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Lay thong tin tat ca cac file trong mot bucket
     */
    public function getBucketAllFileInfo($bucketId, $user, $pass)
    {

        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Lay thong tin chi tiet cua file trong bucket
     */
    public function getBucketFileDetail($bucketId, $fileName, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/search?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&vvp-di-file-keyname='.$fileName;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Xin cap phat mot danh sach cac file rong trong mot bucket
     */
    public function bucketBookFile($bucketId, $bucketFile, $user='', $pass='')
    {
        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }

        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $body = '<emptyFiles>';
        foreach($bucketFile as $filename)
        {
            $body .= '<emptyFile>
                <fileName>'.$filename.'</fileName>
            </emptyFile>';
        }
        $body .= '</emptyFiles>';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_POST, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * upload mot file len bucket
     */
    public function upFileToBucket($bucketId, $filePath, $keyname, $user='', $pass='')
    {
        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }

        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('vvp-di-file'=>"@$filePath",'vvp-di-file-keyname'=>"$keyname"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
		print_r($result);
        curl_close($ch);

        return $result;
    }

    /**
     * upload overwrite len mot file da ton tai trong bucket
     */
    public function upOverwriteFileToBucket($bucketId, $fileId, $filePath, $fileNameNew, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        //echo $url.'<br/>';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('vvp-di-file'=>"@$filePath",'vvp-di-file-keyname'=>"$fileNameNew"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    /**
     * cap nhat thong tin cua mot file
     */
    public function updateFileInfo($bucketId, $fileId, $keyname, $meta='', $storageClass, $user, $pass)
    {

        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;


        $body = '<file>
                    <keyName>'.$keyname.'</keyName>
                    <metadata>'.$meta.'</metadata>
                    <storageClass>'.$storageClass.'</storageClass>
                </file>
                ';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_POST, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    /**
     * Xoa file
     */
    public function deleteFile($fileId, $bucketId, $user='', $pass='')
    {
		if($fileId>0)
		{
			if(trim($user)=='')
			{
				$user = $this->params['storagekey']['Indexing']['apikey'];
			}
			if(trim($pass)=='')
			{
				$pass = $this->params['storagekey']['Indexing']['apipass'];
			}

			$url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			$result = curl_exec($ch);
			curl_close($ch);

			//return $result;

			//return resonpse header, check header if httpResponse 200 OK
			$header = get_headers($url);
			return array('result'=>$result, 'header'=>$header);
		}
		return;
    }

    /**
     * Xoa all file
     */
    public function deleteAllFile($bucketId, $user='', $pass='')
    {

			if(trim($user)=='')
			{
				$user = $this->params['storagekey']['Indexing']['apikey'];
			}
			if(trim($pass)=='')
			{
				$pass = $this->params['storagekey']['Indexing']['apipass'];
			}

			$url = $this->params['storagehost'].'buckets/'.$bucketId.'/files?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			$result = curl_exec($ch);
			curl_close($ch);



			//return $result;

			//return resonpse header, check header if httpResponse 200 OK
			$header = get_headers($url);
			return array('result'=>$result, 'header'=>$header);

    }

    /**
     * Lay thong tin chi tiet cua file qua Id
     */
    public function getFileInfoById($fileId, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&vvp-di-file-id='.$fileId;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;

        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    /**
     * Lay thong tin chi tiet cua file
     */
    public function getFileInfo($fileId, $bucketId, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

	public function getStreamingUrlApi($fileId, $bucketId=4,$remoteIp )
    {
        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }
        $host= $this->params['streaminghost'];
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'/delivery_url?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&streaming-domain='.$host.'&vvp-di-file-secretkey=fa0e8f3fd2&vvp-di-file-host='.$remoteIp;


		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);

	      curl_close($ch);
        return $result;
    }

	public function getStreamingTimeoutUrlApi($fileId, $bucketId=4,$remoteIp )
    {
        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }
        $host= $this->params['streaminghost'];
         $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'/delivery_url_timeout?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&vvp-di-file-secretkey=fa0e8f3fd2&vvp-di-file-timeout=60';

		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
	      curl_close($ch);
        return $result;
    }

	public function getRtspStreamingUrlApi($fileId, $bucketId=4,$remoteIp,$msisdn )
    {
        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }
        $host= $this->params['streaminghost'];
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'/rtsp_url?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&rtsp-domain='.$host.'&rtsp-secretkey=fa0e8f3fd2&rtsp-clientadd='.$remoteIp.'&rtsp-msisdn='.$msisdn.'&rtsp-channel=vod';

		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
	      curl_close($ch);
        return $result;
    }

	public function getRtspStreamingTimeoutUrlApi($fileId, $bucketId=4,$msisdn )
    {

        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }
        $host= $this->params['streaminghost'];
		$url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'/rtsp_url?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&rtsp-domain='.$host.'&rtsp-secretkey=fa0e8f3fd2&rtsp-msisdn='.$msisdn.'&rtsp-channel=vod';

		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
	      curl_close($ch);
        return $result;
    }

    /**
     * Lay thong tin url cua file
     */

	public function getStreamingUrl($fileId, $bucketId, $user='', $pass='')
    {
        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }
        $host= $this->params['streaminghost'];
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'/delivery_url?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&streaming-domain='.$host.'&vvp-di-file-secretkey=fa0e8f3fd2&vvp-di-file-host='.$_SERVER['REMOTE_ADDR'];

		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
	      curl_close($ch);
        return $result;
    }

	public function getStreamingUrlTimeout($fileId, $bucketId, $user='', $pass='')
    {
        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }
        $host= $this->params['streaminghost'];
        //$url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'/delivery_url?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&streaming-domain='.$host.'&vvp-di-file-secretkey=fa0e8f3fd2&vvp-di-file-host='.$_SERVER['REMOTE_ADDR'];
       	 $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'/delivery_url_timeout?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&vvp-di-file-secretkey=fa0e8f3fd2&vvp-di-file-timeout=60';
		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
	      curl_close($ch);
        return $result;
    }

    /**
     * Lay thong tin download file
     */
    public function getFileDownload($fileId, $bucketId, $user='', $pass='')
    {
        if(trim($user)=='')
        {
            $user = $this->params['storagekey']['Indexing']['apikey'];
        }
        if(trim($pass)=='')
        {
            $pass = $this->params['storagekey']['Indexing']['apipass'];
        }

        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/files/'.$fileId.'/download?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Khoi tao multiupload
     */
    public function createMultiupload($bucketId, $numPart, $fileName, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/multiuploads?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass.'&vvp-di-file-partsize'.$numPart.'&vvp-di-file-filename='.$fileName;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    /**
     * Huy bo multiupload
     */
    public function cancelMultiupload($bucketId, $mulId, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/multiuploads/'.$mulId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    /**
     * upload part
     * chua hoan chinh
     */
    public function uploadPart($bucketId, $mulId, $partIndex, $file, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/multiuploads/'.$mulId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('vvp-di-file-part'=>"@$filePath",'vvp-di-file-part-index'=>"$partIndex"));
        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    /**
     * upload part
     * chua hoan chinh
     */
    public function getPartInfo($bucketId, $mulId, $partIndex, $file, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/multiuploads/'.$mulId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    /**
     * hoan thien multiupload
     * chua hoan chinh
     */
    public function completeMultiupload($bucketId, $mulId, $partIndex, $file, $user, $pass)
    {
        $url = $this->params['storagehost'].'buckets/'.$bucketId.'/multiuploads/'.$mulId.'?vvp-di-apikey='.$user.'&vvp-di-pass='.$pass;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        $result = curl_exec($ch);
        curl_close($ch);

        //return $result;
        $header = get_headers($url);
        return array('result'=>$result, 'header'=>$header);
    }

    public function messageArray($message)
    {
        $object = array();
        $xml = simplexml_load_string($message);
        foreach($xml->children() as $child)
        {
            $object[$child->getName()] = $child;
        }
        return $object;
    }
}
?>
