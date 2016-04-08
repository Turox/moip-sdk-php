<?php

namespace Moip\Resource;

use Moip\Http\HTTPRequest;
use stdClass;


class Notification extends MoipResource{
    const PATH = 'notifications';
    
    /**
     * Initialize necessary used in some functions.
     */
    protected function initialize() {
        $this->data = new stdClass();
        $this->data->media = "WEBHOOK";
        $this->data->target = null;
        $this->data->token = null;
        $this->data->id = null;
        $this->data->events = [];
    }

    /**
     * Mount the structure of order.
     *
     * @param \stdClass $response
     *
     * @return \Moip\Resource\Notification instance.
     */
    protected function populate(stdClass $response) {
        $this->data->media = $response->media;
        $this->data->target = $response->target;
        $this->data->token = $response->token;
        $this->data->id = $response->id;     
        $this->data->events = $response->events;

        return $this;
    }
    
    /**
     * Create a new Notification in MoIP
     * 
     * @return stdClass
     */
    public function create(){
        return $this->createResource(sprintf('/%s/%s/%s', MoipResource::VERSION, Preferences::PATH, self::PATH));
    }
    
    /**
     * Delete new Notification in MoIP
     * 
     * @return 
     */
    public function delete($id_moip=null){
        $id = $id_moip;
        if(isset($this->data->id)){
         $id = $this->data->id;
        }        
        if(isset($id)){
            return $this->httpRequest(sprintf('/%s/%s/%s/%s', MoipResource::VERSION, Preferences::PATH, self::PATH, $id), HTTPRequest::DELETE);            
        }else{
            throw new \Moip\Exceptions\UnexpectedException;
        }
    }
    /**
     * Get a Notification in MoIP
     * 
     * @param string $id_moip MoIP Notification ID
     * @return stdClass
     */
    public function get($id_moip)
    {
        return $this->getByPath(sprintf('/%s/%s/%s/%s', MoipResource::VERSION, Preferences::PATH, self::PATH, $id_moip));
    }
    
    /**
     * Get all Notifications in MoIP
     * 
     * @return stdClass Array
     */
    public function getAllNotifications(){
        return $this->httpRequest(sprintf('/%s/%s/%s', MoipResource::VERSION, Preferences::PATH, self::PATH), HTTPRequest::GET);
    }
    /**
     * Set URL targeted by Notifcation's webhooks
     * 
     * @param string $target
     * @return \Moip\Resource\Notification
     */
    public function setTarget($target){
        $this->data->target = $target;
        return $this;
    }
    
    /**
     * Get URL targeted by Notifcation's webhooks
     * @return string
     */
    public function getTarget(){
        return $this->data->target;
    }

    /**
     * Set Notification type
     * @param string $media
     * @return \Moip\Resource\Notification
     */
    public function setMedia($media){
        $this->data->media = $media;
        return $this;
    }
    /**
     * Get Notification type
     * @return string
     */
    public function getMedia(){
        return $this->data->media;
    }

    /**
     * Add a Notification Event
     * See: http://dev.moip.com.br/referencia-api/#lista-de-webhooks-disponveis for possible values
     * @param string $event
     * @return \Moip\Resource\Notification
     */
    public function addEvent($event){
        $this->data->events[] = $event;
        return $this;
    }
    /**
     * Remove an Notifcation's Event
     * @param string $event
     * @return \Moip\Resource\Notification
     */
    public function removeEvent($event){
        if(($key = array_search($event, $this->data->event)) !== false) {
            unset($this->data->event[$key]);
        }
        return $this;
    }
}
