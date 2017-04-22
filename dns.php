<?php

/**
 * Description of dns
 *
 * To retrieve and work with DNS records. with php-native functions only.
 */
class dns {

    protected $hostname;
    protected $dns_records;
    protected $dns_types = array(
        'A',
        'AAAA',
        'CNAME',
        'MX',
        'NS',
        'TXT',
        'SRV',
        'CAA',
        'PTR',
        'SOA',
        'HINFO',
        'NAPTR',
        'A6',
    );
    protected $protocol_list = array(
        'http://',
        'https://',
        'ftp://',
        'ftps://',
    );

    public function __construct($hostname) {
        if ($hostname == "") {
            die("<b>Error</b>, No hostname added!");
        }
        $this->hostname = $this->clean_url($hostname);
    }

    /**
     * Get the hostname
     *
     * @access	public
     * @return	string hostname
     */
    public function get_hostname() {
        return $this->hostname;
    }

    /**
     * Get DNS records from hostname
     *
     * @access	public
     * @param	string | multiple strings $types - Type of DNS record
     * @return	array
     */
    public function get_records(...$types) {
        if (count($types) == 0) {
            $types = $this->dns_types;
        }

        $types = $this->check_dns_type($types);
        $dns_records = array_map([$this, 'get_records_type'], $types);

        return array_filter($dns_records);
    }

    /**
     * Remove the protocole from a domainname and checks if the domain name exsists.
     *
     * @access	protected
     * @param	array $types - Type of DNS record
     * @return	hostname
     */
    protected function check_dns_type($types) {
        $uppercase_types = array_map('strtoupper', $types);

        foreach ($uppercase_types as $value) {
            if (!in_array($value, $this->dns_types)) {
                die("<b>Error</b>, Not possible to find DNS type: <b>" . $value . "</b>.");
            }
        }

        return $uppercase_types;
    }

    /**
     * Remove the protocol and slashes from a domainname
     *
     * @access	protected
     * @param	string $hostname - Hostname
     * @return	hostname
     */
    protected function clean_url($hostname) {
        $domain = str_replace($this->protocol_list, '', $hostname);

        $split_domain = explode("/", $domain);

        return $split_domain[0];
    }

    /**
     * Get all records from one type
     *
     * @access	protected
     * @param	string $type Type of DNS record
     * @return	array
     */
    protected function get_records_type($type) {
        $records = array();

        if (empty($this->dns_records)) {
            $this->dns_records = dns_get_record($this->hostname);
        }

        foreach ($this->dns_records as $value) {
            if ($value['type'] === $type) {
                array_push($records, $value);
            }
        }

        return $records;
    }

}
