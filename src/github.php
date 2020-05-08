<?php
    namespace Github;
    class Github {
        private $token;
        public $apiurl = "https://api.github.com/";
        public $curl_returntransfer;
        public $curl_timeout;
        public $user_agent;

        public function __construct($user_agent="", $token="", $returntransfer=true, $timeout=1, $apiurl="https://api.github.com/"){
            $this->user_agent = $user_agent; // Username/App name
            $this->token = $token; // Personal access tokens
            $this->curl_returntransfer = $returntransfer; // CURLOPT_RETURNTRANSFER
            $this->curl_timeout = $timeout; // CURLOPT_TIMEOUT
            $this->apiurl = $apiurl; // GITHUB API URL : https://api.github.com/
        }

        function get($url, $jsondecode=true){
            if(isset($url) && !empty($url)){
                $curl = curl_init($this->apiurl.$url);
                curl_setopt_array($curl, [
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        'User-Agent: '.$this->user_agent,
                        'Authorization: token '.$this->token,
                    ),
                    CURLOPT_RETURNTRANSFER => $this->curl_returntransfer,
                    CURLOPT_TIMEOUT => $this->curl_timeout
                ]);
                $data = curl_exec($curl);
                curl_close($curl);
                if($data === false){
                    return false;
                } else {
                    if($jsondecode){
                        $data = json_decode($data);
                    }
                    return $data;
                }
            }
            return false;
        }

        function post($url, $params=array()){
            if(isset($url) && !empty($url)){
                $curl = curl_init($this->apiurl.$url);
                curl_setopt_array($curl, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $params,
                    CURLOPT_HTTPHEADER => array(
                        'User-Agent: '.$this->user_agent,
                        'Authorization: token '.$this->token,
                    ),
                    CURLOPT_RETURNTRANSFER => $this->curl_returntransfer,
                    CURLOPT_TIMEOUT => $this->curl_timeout
                ]);
                $data = curl_exec($curl);
                curl_close($curl);
                return $data;
            }
            return false;
        }

        function put($url, $params=array()){
            if(isset($url) && !empty($url)){
                $curl = curl_init($this->apiurl.$url);
                curl_setopt_array($curl, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $params,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_HTTPHEADER => array(
                        'User-Agent: '.$this->user_agent,
                        'Authorization: token '.$this->token,
                    ),
                    CURLOPT_RETURNTRANSFER => $this->curl_returntransfer,
                    CURLOPT_TIMEOUT => $this->curl_timeout
                ]);
                $data = curl_exec($curl);
                curl_close($curl);
                return $data;
            }
            return false;
        }

        function patch($url, $params=array()){
            if(isset($url) && !empty($url)){
                $curl = curl_init($this->apiurl.$url);
                curl_setopt_array($curl, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $params,
                    CURLOPT_CUSTOMREQUEST => "PATCH",
                    CURLOPT_HTTPHEADER => array(
                        'User-Agent: '.$this->user_agent,
                        'Authorization: token '.$this->token,
                    ),
                    CURLOPT_RETURNTRANSFER => $this->curl_returntransfer,
                    CURLOPT_TIMEOUT => $this->curl_timeout
                ]);
                $data = curl_exec($curl);
                curl_close($curl);
                return $data;
            }
            return false;
        }

        function delete($url){
            if(isset($url) && !empty($url)){
                $curl = curl_init($this->apiurl.$url);
                curl_setopt_array($curl, [
                    CURLOPT_CUSTOMREQUEST => "DELETE",
                    CURLOPT_HTTPHEADER => array(
                        'User-Agent: '.$this->user_agent,
                        'Authorization: token '.$this->token,
                    ),
                    CURLOPT_RETURNTRANSFER => $this->curl_returntransfer,
                    CURLOPT_TIMEOUT => $this->curl_timeout
                ]);
                $data = curl_exec($curl);
                curl_close($curl);
                return $data;
            }
            return false;
        }

        // User Agent
        function getUserAgent(){
            return $this->user_agent;
        }

        // Token
        private function getToken(){
            return $this->token;
        }
        
        // Rate Limit
        function isLimit(){ // https://api.github.com/rate_limit
            $data = $this->get("rate_limit");
            if($data == false){
                return false;
            }

            return $data->resources->core->limit == abs($data->resources->core->limit-$data->resources->core->remaining);
        }

        function Limit_Remaining(){ // https://api.github.com/rate_limit
            $data = $this->get("rate_limit");
            if($data == false){
                return false;
            }

            return abs($data->resources->core->limit-$data->resources->core->remaining)."/".$data->resources->core->limit;
        }

        function getLimit($limit){ // https://api.github.com/rate_limit
            $data = $this->get("rate_limit");
            if($data === false){
                return false;
            }

            if(isset($limit)){
                if($limit == "core/limit"){
                    return $data->resources->core->limit;
                }
                if($limit == "core/remaining"){
                    return abs($data->resources->core->limit-$data->resources->core->remaining);
                }
                if($limit == "core/reset"){
                    return $data->resources->core->reset;
                }
                
                if($limit == "search/limit"){
                    return $data->resources->search->limit;
                }
                if($limit == "search/remaining"){
                    return $data->resources->search->remaining;
                }
                if($limit == "search/reset"){
                    return $data->resources->search->reset;
                }

                if($limit == "graphql/limit"){
                    return $data->resources->graphql->limit;
                }
                if($limit == "graphql/remaining"){
                    return $data->resources->graphql->remaining;
                }
                if($limit == "graphql/reset"){
                    return $data->resources->graphql->reset;
                }
            }
            return $data;
        }

        // Releases
        function getListReleases($owner, $repo){ // https://api.github.com/repos/:owner/:repo/releases
            $data = $this->get("repos/".$owner."/".$repo."/releases");
            if($data === false){
                return false;
            }
            return $data;
        }

        function getReleaseByID($owner, $repo, $release_id){ // https://api.github.com/repos/:owner/:repo/releases/:release_id
            $data = $this->get("repos/".$owner."/".$repo."/releases/".$release_id);
            if($data === false){
                return false;
            }
            return $data;
        }

        function getReleaseByTag($owner, $repo, $release_tag){ // https://api.github.com/repos/:owner/:repo/releases/tags/:release_tag
            $data = $this->get("repos/".$owner."/".$repo."/releases/tags/".$release_tag);
            if($data === false){
                return false;
            }
            return $data;
        }

        function getListAssets($owner, $repo, $release_id){ // https://api.github.com/repos/:owner/:repo/releases/:release_id/assets
            $data = $this->get("repos/".$owner."/".$repo."/releases/".$release_id."/assets");
            if($data === false){
                return false;
            }
            return $data;
        }

        function getAsset($owner, $repo, $asset_id){ // https://api.github.com/repos/:owner/:repo/releases/assets/:asset_id
            $data = $this->get("repos/".$owner."/".$repo."/releases/assets/".$asset_id);
            if($data === false){
                return false;
            }
            return $data;
        }

        function getLatestRelease($owner, $repo){ // https://api.github.com/repos/:owner/:repo/releases/latest
            $data = $this->get("repos/".$owner."/".$repo."/releases/latest");
            if($data === false){
                return false;
            }
            return $data;
        }

        // Downloads
        function getListDownloads($owner, $repo){ // https://api.github.com/repos/:owner/:repo/downloads
            $data = $this->get("repos/".$owner."/".$repo."/downloads");
            if($data === false){
                return false;
            }
            return $data;
        }

        function getDownloado($owner, $repo, $download_id){ // https://api.github.com/repos/:owner/:repo/downloads/:download_id
            $data = $this->get("repos/".$owner."/".$repo."/downloads/".$download_id);
            if($data === false){
                return false;
            }
            return $data;
        }

        function DeleteDownload($owner, $repo, $download_id){ // https://api.github.com/repos/:owner/:repo/downloads/:download_id
            $data = $this->delete("repos/".$owner."/".$repo."/downloads/".$download_id);
            if($data === false){
                return false;
            }
            return $data;
        }

        // Comments
        function getListComments($owner, $repo){ // https://api.github.com/repos/:owner/:repo/comments
            $data = $this->get("repos/".$owner."/".$repo."/comments");
            if($data === false){
                return false;
            }
            return $data;
        }

        function getListCommentsForSingleCommit($owner, $repo, $commit_sha){ // https://api.github.com/repos/:owner/:repo/commits/:commit_sha/comments
            $data = $this->get("repos/".$owner."/".$repo."/commits/".$commit_sha."/comments");
            if($data === false){
                return false;
            }
            return $data;
        }

        function CreateCommitComment($owner, $repo, $commit_sha, $array=array("body" => "", "path" => "", "postion" => 0, "line" => null)){ // https://api.github.com/repos/:owner/:repo/commits/:commit_sha/comments
            $data = $this->post("repos/".$owner."/".$repo."/commits/".$commit_sha."/comments", $array);
            if($data === false){
                return false;
            }
            return $data;
        }

        function GetCommitComment($owner, $repo, $comment_id){ // https://api.github.com/repos/:owner/:repo/comments/:comment_id
            $data = $this->get("repos/".$owner."/".$repo."/comments/".$comment_id);
            if($data === false){
                return false;
            }
            return $data;
        }

        function UpdateCommitComment($owner, $repo, $comment_id, $array=array("body" => "")){ // https://api.github.com/repos/:owner/:repo/commits/:commit_sha/comments
            $data = $this->patch("repos/".$owner."/".$repo."/comments/".$comment_id, $array);
            if($data === false){
                return false;
            }
            return $data;
        }

        function DeleteCommitComment($owner, $repo, $comment_id){ // https://api.github.com/repos/:owner/:repo/comments/:comment_id
            $data = $this->delete("repos/".$owner."/".$repo."/comments/".$comment_id);
            if($data === false){
                return false;
            }
            return $data;
        }

        // Collaborators
        function GetListCollaborators($owner, $repo){ // https://api.github.com/repos/:owner/:repo/collaborators
            $data = $this->get("repos/".$owner."/".$repo."/collaborators");
            if($data === false){
                return false;
            }
            return $data;
        }

        function CheckUserIsCollaborator($owner, $repo, $username){ // https://api.github.com/repos/:owner/:repo/collaborators/:username
            $data = $this->get("repos/".$owner."/".$repo."/collaborators/".$username);
            return $data;
        }

        function GetUserPermissionLevel($owner, $repo, $username){ // https://api.github.com/repos/:owner/:repo/collaborators/:username/permission
            $data = $this->get("repos/".$owner."/".$repo."/collaborators/".$username."/permission");
            return $data;
        }

        function DeleteUserCollaborator($owner, $repo, $username){ // https://api.github.com/repos/:owner/:repo/collaborators/:username
            $data = $this->delete("repos/".$owner."/".$repo."/collaborators/".$username);
        }
    }
?>
