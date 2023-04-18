<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UserDetailFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    if (user()->complete_reg == 0)
      return redirect()->to('account');
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
  }
}
