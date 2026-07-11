import AsyncSelect from 'react-select/async';
import { useState } from 'react';

function ClientSearch({ childChanged, error }) {

    const [client, setClient] = useState('');

    const getClients = async (inputValue) => {

        if (!inputValue) return [];

        const res = await fetch(`/clients/search?q=${encodeURIComponent(inputValue)}`);
        const data = await res.json();

        return data;
    };

    function handleChildChange(option) {
        setClient(option);
        childChanged(option);
    }

    return (
        <>
            <div className="form-group">
                <AsyncSelect
                    classNamePrefix="react-select"
                    cacheOptions
                    // defaultOptions
                    loadOptions={getClients}
                    value={client}
                    onChange={handleChildChange}
                    placeholder=""
                    noOptionsMessage={() => "موردی یافت نشد"}
                    isClearable
                />
                <label htmlFor="exporter"> دریافت کننده</label>
                {error && <div className="errors">{error}</div>}
            </div>
        </>
    )
}

export default ClientSearch;