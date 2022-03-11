<?php

namespace BlackSpot\Starter\Traits\App;

use BlackSpot\Starter\ConditionalRedirect;

trait HasRedirects{

    /**
     * Url or Routes
     *
     * @var array
     */
    public $registeredRedirects;

    public function registerRedirects(array $redirects = [])
    {        
        $this->registeredRedirects = [];

        foreach ($redirects as $key => $url) {            
          if (!$this->isUri($url) && !$this->isRouteName($url) && !$this->isUrl($url)) {
            throw new \Exception("URL NOT SUPPORTED! [{$url}]", 1);
          }
          $this->registeredRedirects[$key] = $url;
        }
    }

    /**
     * Get the registered redirects
     * 
     * @return array
     */
    public function getRegisteredRedirects()
    {
        return $this->registeredRedirects ?? [];
    }

    /**
     * Build http query
     * 
     * @return string
     */
    public function getRegisteredRedirectsAsHttpQuery()
    {
      return http_build_query($this->registeredRedirects);
    }

    public function isUri($url)
    {
      return strpos($url, 'url:') !== false;
    }    
    public function isUrl($url)
    {
      return strpos($url, 'http') !== false;
    }
    public function isRouteName($url)
    {
        return strpos($url, 'url:') === false && strpos($url,' ') === false ;
    }

    public function clearUri($url)
    {
        return str_replace('url:','',$url);
    }

    public function buildRouteWithArguments($url)
    {
      $wrap = [$url];

      if (strpos($url,'?') !== false) {
        //has arguments
        $explode   = explode('?',$url);
        $wrap[0]   = $explode[0]; // URL

        $arguments = [];        

        if (isset($explode[1])) {
          foreach (explode('&',$explode[1]) as $argument) {
            $argumentExploded                = explode('=', $argument); //query=value
            $arguments[$argumentExploded[0]] = $argumentExploded[1];
          }
        }        
        if (!empty($arguments)) {
          array_push($wrap,$arguments);
        }
      }
      return $wrap;
    }

    public function redirectExists(string $on)
    {
      return isset($this->registeredRedirects[$on]);
    }


    /**
     * Validate if there are registered redirects
     * 
     * @return boolean
     */
    public function thereAreRegisteredRedirects()
    {
      return !empty($this->getRegisteredRedirects());
    }



    /**
     * Validate if its an valid url and return it as Redirector object
     * 
     * @param string $concreteRedirect
     * @throws \Exception
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Livewire\Redirector
     */
    public function validateRouteAndThenReturnItAsObject(string $concreteRedirect)
    {
      if ($this->isRouteName($concreteRedirect)) {
        return redirect()->route(...$this->buildRouteWithArguments($concreteRedirect));
      }elseif ($this->isUri($concreteRedirect)) {
        return redirect($this->clearUri($concreteRedirect));
      }elseif ($this->isUrl($concreteRedirect)) {
        return redirect($concreteRedirect);
      }else {
        throw new \Exception("Redirect not supported", 1);
      }
    }

    /**
     * Validate if its an valid url and return it as full url string
     * 
     * @param string $concreteRedirect
     * @throws \Exception
     * @return string
     */
    public function validateRouteAndThenReturnItAsString(string $concreteRedirect){
      if ($this->isRouteName($concreteRedirect)) {
        return route(...$this->buildRouteWithArguments($concreteRedirect));
      }elseif ($this->isUri($concreteRedirect)) {
        return url($this->clearUri($concreteRedirect));
      }elseif ($this->isUrl($concreteRedirect)) {
        return $concreteRedirect;
      }else {
        throw new \Exception("Redirect not supported", 1);
      }
    }



    /**
     * Get the full url if exists
     * 
     * @return null\string
     */
    public function getFullRedirectString(string $to, string $redirectDefault = '')
    {
      if ($this->redirectExists($to)) {
        return $this->validateRouteAndThenReturnItAsString($this->registeredRedirects[$to]);
      }elseif (!empty($redirectDefault)) {
        return $this->validateRouteAndThenReturnItAsString($redirectDefault);
      }      
    }

    /**
     * Redirect to url if exists
     * 
     * @return null\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Livewire\Redirector
     */
    public function redirectToUrl(string $to, string $redirectDefault = '')
    {      
      if ($this->redirectExists($to)) {
        return $this->validateRouteAndThenReturnItAsObject($this->registeredRedirects[$to]);
      }elseif (!empty($redirectDefault)) {
        return $this->validateRouteAndThenReturnItAsObject($redirectDefault);
      }
    }

    /**
     * Creates a conditional redirect
     * 
     * @return \BlackSpot\Starter\ConditionalRedirect
     */
    public function conditionalRedirect()
    {
      return new ConditionalRedirect([
        $this->registeredRedirects
      ]);
    }


}
