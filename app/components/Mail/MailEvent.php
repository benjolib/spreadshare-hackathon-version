<?php

namespace DS\Component\Mail;

use DS\Component\Mail\ViewParams\DefaultParams;
use DS\Component\Queue\QueueInterface;
use DS\Constants\Services;
use DS\Model\Abstracts\AbstractUser;
use DS\Traits\DiInjection;
use Phalcon\DiInterface;
use Phalcon\Mailer\Manager;
use Phalcon\Mailer\Message;

/**
 * Spreadshare
 *
 * Mailing
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Component\Mail
 */
class MailEvent
{
    use DiInjection;
    
    /**
     * @var MailQueue
     */
    protected $queue;
    
    /**
     * @var MailManager
     */
    protected $mailManager;
    
    /**
     * @var Message
     */
    protected $message;
    
    /**
     * @var string
     */
    protected $viewPath = 'mails/default/layout.volt';
    
    /**
     * @var string
     */
    protected $subject = '';
    
    /**
     * @return mixed
     */
    public function getQueue()
    {
        return $this->queue;
    }
    
    /**
     * @param QueueInterface $queue
     *
     * @return $this
     */
    public function setQueue($queue)
    {
        $this->queue = $queue;
        
        return $this;
    }
    
    /**
     * @return MailManager
     */
    public function getMailManager()
    {
        return $this->mailManager;
    }
    
    /**
     * @param Manager $mailer
     *
     * @return $this
     */
    public function setMailManager($mailManager)
    {
        $this->mailManager = $mailManager;
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function send()
    {
        //@todo enable queuing maybe?
        //$this->queue->queue($this->message);
        
        $returnCode = $this->mailManager->sendViaGuzzle($this->message);
        
        return $this;
    }
    
    /**
     * Prepare a message that is going to be send to a user
     *
     * @param DefaultParams $viewParams
     * @param AbstractUser  $userModel
     */
    protected function prepareUserMessage(DefaultParams $viewParams, AbstractUser $userModel)
    {
        /**
         * Creating a new Volt view instance here since using
         * $this->mailmanager->createMessageFromView did not work!
         *
         * Original code was: $this->message =
         * $this->mailManager->createMessageFromView($this->viewPath, $viewParams->toArray())
         * ->to($userModel->getEmail(), $userModel->getName())
         * ->subject($this->subject);
         */
        $message = $this->mailManager->createMessage();
        
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir(ROOT_PATH . '/app/views/');
        $volt = new \Phalcon\Mvc\View\Engine\Volt($view);
        
        $this->message =
            $message->content($volt->render(ROOT_PATH . '/app/views/' . $this->viewPath, $viewParams->toArray()), $message::CONTENT_TYPE_HTML)
                    ->to($userModel->getEmail(), $userModel->getName())
                    ->subject($this->subject);
    }
    
    /**
     * @param DiInterface $di
     *
     * @return $this
     */
    public static function factory(DiInterface $di)
    {
        $self = new static($di);
        
        // queue is disabled, in favour of the Mailgun service
        //$self->setQueue($di->get(Services::QUEUE));
        
        $self->setMailManager($di->get(Services::MAILER));
        
        return $self;
    }
    
}
