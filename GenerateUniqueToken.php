    /**
     * {@inheritDoc}
     */
    public function generateUniqueToken()
    {
        do {
            $token = $this->generator->generate($this->tokenLength);
        } while ($this->isUsedCode($token));
        return $token;
    }
    /**
     * @param string $token
     *
     * @return Boolean
     */
    protected function isUsedCode($token)
    {
        $this->manager->getFilters()->disable('softdeleteable');
        $isUsed = null !== $this->repository->findOneBy(array('confirmationToken' => $token));
        $this->manager->getFilters()->enable('softdeleteable');
        return $isUsed;
    }
    
