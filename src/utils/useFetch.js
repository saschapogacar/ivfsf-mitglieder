import { useEffect, useState } from 'react';
import axios from 'axios';

export default function useFetch(url) {
    const [data, setData] = useState(null);
    useEffect(() => {
        axios.get(url).then(
            result => {
                console.log("useFetch: " + result)
                    //  let json = JSON.parse(result.data)
                    //  console.log(json)

                setData(result.data)

            },
            // Note: it's important to handle errors here
            // instead of a catch() block so that we don't swallow
            // exceptions from actual bugs in components.
            error => {
                setData(error)
            }
        );

    }, [url]);
    return data;
}