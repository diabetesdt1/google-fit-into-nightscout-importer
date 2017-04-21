<?php
//////////////////////////////////////////////////////////////////////
//
//      Projekt:   a other... old stuff :-)
//      Datei:     class/Filestuff.class.php
//      Version:   see $config['mainversion']
//      Datum:     21.02.2009
//      Author:    Martin
//      Descr.:    old....
//      license:   use it, but not comercial
//
//////////////////////////////////////////////////////////////////////


class FileStuff
  {
    public $useragent;
    public function __construct($config)
      {
        # download with witch function?
        $this->config      = $config;
      }




    public function GetRemoteData($url)
      {
        $this->url = $url;
// file_get_contents not tested!!!!
//
//
/*
        $disabled  = ini_get('disable_functions');
        if((stripos($disabled, 'allow_url_fopen') === FALSE) && (stripos($disabled, 'file_get_contents') === FALSE) && ($this->secure != 1))
          {
            $postdaten = http_build_query($this->postdata);
            if((isset($requeststring)) && (!empty($requeststring)))
              {
                $ops  = array('http' => array('method' => 'POST', 'header' => "Accept-language: en\r\nContent-Type: application/x-www-form-urlencoded\r\nUser-Agent: ".$this->useragent."\r\nAPI-SECRET: ".$this->config['apisecret']."\r\n", 'timeout' => $this->config['timeout'], 'content' => $postdaten));
              }
            else
              {
                $ops  = array('http' => array('method' => 'POST', 'header' => "Accept-language: en\r\nContent-Type: application/x-www-form-urlencoded\r\nUser-Agent: ".$this->useragent."\r\nAPI-SECRET: ".$this->config['apisecret']."\r\n", 'timeout' => $this->config['timeout']));
              }
            $context  = stream_context_create($ops);
            if(!$data = file_get_contents($url, false, $context))
              {
                $data = 'via file_get_contents('.$url.'):  '.$this->GetHeaders(@$http_response_header);
              }
          }
*/
        if((extension_loaded('curl')) || ($this->secure == 1))
          {
            $data = $this->GetCurl();
            if(empty($data))
              {
                $data = 'ERROR: via CURL:  '.$this->GetHeaders($this->infos);
              }
          }
        else
          {
            die('need php extension curl');
          }
        if((!isset($data)) || (empty($data)))
          {
            $data = 'ERRORk, no data/errors come back?!?!?!? i dont know, this code is very, very old...  via file_get_contents, CURL, WGET.....:  ';
          }
        return($data);
      }





    private function GetHeaders($header)
      {
        $dats   = '';
        $errors = count($header);
        for($i  = 0; $i < $errors; $i++)
          {
            if($i == 0)
              {
                $dats = "\n\nERROR: \n".$header[0]."\n\n";
              }
            elseif(isset($header[$i]))
              {
                $dats .= $header[$i]."\n";
              }
          }
        return($dats);
      }





    private function GetCurl()
      {
        $curldata  = 0;
        $follow    = 1;
        if(stripos($this->config['apiurl'], 'https://') !== FALSE)
          {
            $this->secure = 1;
            $this->port   = 443;
          }
         else
           {
              $this->secure = 0;
               $this->port   = 80;
            }
          if(isset($this->oonfig['secure']))
            {
              $this->secure = $this->config['secure'];
            }
        $ch        = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_FAILONERROR, FALSE);
        if(ini_get('safe_mode') != 'on')
          {
            $follow = 0;
          }
        if(ini_get('open_basedir') != 'on')
          {
            $follow = 0;
          }
        if($follow == 1)
          {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          }
        $sslstrict = 0;
        if($this->secure == 1)
          {
             $sslstrict = 2;
           }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_PORT, $this->port);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->config['timeout']);
        curl_setopt($ch, CURLOPT_USERAGENT, 'asdfasdf');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $sslstrict);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $sslstrict);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: '.@strlen($this->postdata), 'API-SECRET: '.$this->config['apisecret']));


        if((isset($this->postdata)) && ((!empty($this->postdata)) || (is_array($this->postdata))))
          {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postdata);
          }
        $this->body     = curl_exec($ch);
        $this->infos    = curl_getinfo($ch);
        $this->infos[0] = $this->body;
        $this->erros    = curl_error($ch);
        if(!empty($this->body))
          {
             $curldata = json_decode($this->body, TRUE);
          }
        else
          {
            if($this->infos['http_code'] == 0)
              {
                $curldata       = 'ERROR';
                $this->header[] = curl_error($ch);
              }
            else
              {
                $curldata       = 'ERROR';
                $this->header[] = 'HTTP: Status-Code: '.$this->infos['http_code'];
              }
          }
        return($curldata);
      }


public function GetError()
  {
    return($this->erros);
  }



    public function SetPostData($data)
      {
        $this->postdata = $data;
      }
  } #Ende
