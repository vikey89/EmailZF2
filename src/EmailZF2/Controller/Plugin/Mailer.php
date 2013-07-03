<?php
/**
 * EMAILZF2 (https://github.com/vikey89/EmailZF2)
 *
 * @link      https://github.com/vikey89/EmailZF2
 * @copyright Copyright (c) 2013 Vikey89
 */
namespace EmailZF2\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Model\ModelInterface;
use Zend\Mail;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

class Mailer extends AbstractPlugin
{
    protected $_from_mail;

    protected $_from_name;

    protected $_renderer;

    protected $_transport;

    public function __construct(RendererInterface $renderer)
    {
        $this->_renderer = $renderer;
    }

    public function send($data = array(), $viewModel)
    {
        if ($viewModel instanceof ModelInterface) {
            $body = $this->renderModel($viewModel);
        }
        elseif (is_string($viewModel)) {
            $body = $this->renderText($viewModel);
        }
        else {
            throw new \Exception('Invalid viewModel for mail body');
        }

        $text = new MimePart('');
        $text->type = "text/plain";

        $html = new MimePart($body);
        $html->type = "text/html";

        $body_html = new MimeMessage();
        $body_html->setParts(array($text, $html));

        $mail = new Mail\Message();
        $mail->setEncoding("UTF-8");
        $mail->setBody($body_html);
        $mail->setFrom($this->_from_mail, $this->_from_name);
        $mail->addTo($data['to']);
        if(isset($data['cc']))
        {
        	$mail->addCc($data['cc']);
        }
        if(isset($data['bcc']))
        {
        	$mail->addBcc($data['bcc']);
        }
        $mail->addReplyTo($this->_from_mail, $this->_from_name);
        $mail->setSubject($data['subject']);

        return $this->_transport->send($mail);
    }

    public function renderModel(ModelInterface $viewModel)
    {
        return $this->_renderer->render($viewModel);
    }

    public function renderText($text)
    {
        return $text;
    }

    public function setFrom($mail, $name)
    {
        $this->_from_mail = $mail;
        $this->_from_name = $name;
    }

    public function getFrom()
    {
        return array($this->_from_mail, $this->_from_name);
    }

    public function setMailTransport(Mail\Transport\TransportInterface $transport)
    {
        $this->_transport = $transport;
    }
}