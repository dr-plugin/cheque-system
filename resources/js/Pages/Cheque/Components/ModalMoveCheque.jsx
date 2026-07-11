
import { useRef, useState } from "react";
import Button from "@/BaseComponents/Button";
import FormField from "@/BaseComponents/FormField";
import ModalBb from "@/BaseComponents/ModalBb";

import { useForm } from '@inertiajs/react';
import ClientSearch from "./ClientSearch";

import { toast } from 'react-toastify';

function ModalMoveCheque({ chequeId, payerId, payerName }) {

    const { data, setData, processing, post, reset, errors } = useForm({
        cheque_id: chequeId,
        payer_id: payerId,
        receiver_id: '',
        comment: ''
    });

    const [isOpen, setIsOpen] = useState(false);

    function addFormData(e) {

        const { id, type, value, checked } = e.target;

        setData((prevData) => {
            let val = type === 'checkbox' ? checked : value;

            return {
                ...prevData,
                [id]: val
            }
        });
    }

    const addReciver = (option) => {
        setData('receiver_id', option.value);
    };

    function createNewLog(e) {

        e.preventDefault();

        post('/logs', {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                toast.success("عملیات با موفقیت انجام شد!");
                setIsOpen(false);
            }
        })
    }

    return (
        <>
            <a type="button" className="button second" onClick={() => setIsOpen(true)}>
                انتقال چک
            </a>

            <ModalBb
                isOpen={isOpen}
                head=" انتقال یک چک"
                onClose={() => setIsOpen(false)}
            >

                <form onSubmit={createNewLog}>

                    <FormField
                        name="payer_name_no_need_in_form"
                        error={errors.payer_id}
                        label="انتقال چک از:"
                        value={payerName}
                        readOnly={true}
                    />

                    <ClientSearch
                        childChanged={addReciver}
                        error={errors.receiver_id}
                    />

                    <FormField
                        name="comment"
                        onChange={addFormData}
                        error={errors.comment}
                        label="توضیحات"
                        value={data.comment}
                    />

                    <Button isLoading={processing} />

                </form>

            </ModalBb>
        </>
    )
}

export default ModalMoveCheque;