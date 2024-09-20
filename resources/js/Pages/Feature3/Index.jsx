
// import { useForm } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";

import Feature from "@/Components/Feature";

import { useState } from "react";
import axios from 'axios';




export default function Index({ feature, answer }) {
    // const { data, setData, post, reset, errors, processing } = useForm({
    //     number1: "",
    //     number2: "",
    // });

    // const submit = (e) => {
    //     e.preventDefault();

    //     post(route("feature1.calculate"), {
    //         onSuccess() {
    //             reset();
    //         },
    //     });
    // };

    const [selectedFile, setSelectedFile] = useState(null);
    const [imageUrl, setImageUrl] = useState(null);

    const handleFileChange = (e) => {
        setSelectedFile(e.target.files[0]);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append('image', selectedFile);

        try {
            const response = await axios.post('/remove-background', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            setImageUrl(response.data.image_url);
        } catch (error) {
            console.error("Error uploading image", error);
        }
    };

    return (
        <Feature feature={feature} answer={answer}>
            {/* <form onSubmit={submit} className="p-8 grid grid-cols-2 gap-3">
                <div>
                    <InputLabel htmlFor="number1" value="Number 1" />

                    <TextInput id="number1" type="text" name="number1" value={data.number1} className="mt-1 block w-full" onChange={(e) => setData("number1", e.target.value)} />

                    <InputError message={errors.number1} className="mt-2" />
                </div>

                <div>
                    <InputLabel htmlFor="number2" value="Number 2" />

                    <TextInput id="number2" type="text" name="number2" value={data.number2} className="mt-1 block w-full" onChange={(e) => setData("number2", e.target.value)} />

                    <InputError message={errors.number2} className="mt-2" />
                </div>

                <div className="flex items-center justify-end mt-4 col-span-2">
                    <PrimaryButton className="ms-4" processing={processing}>
                        Calculate
                    </PrimaryButton>
                </div>
            </form> */}


            <form onSubmit={handleSubmit} className="max-w-lg mx-auto">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload Image</label>
                <input type="file" accept="image/*" onChange={handleFileChange} required className="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" />
                {/* <button type="submit">Upload and Remove Background</button> */}
                <div className="flex items-center justify-center mt-4 mb-4 col-span-2">

                    <PrimaryButton className="ms-4" >
                        Upload and Remove Background
                    </PrimaryButton>

                </div>
            </form>

            {imageUrl && (
                <div className="flex align-center justify-center flex-row">
                    <h2 className="font-bold text-gray-100">Preview:</h2>
                    <img src={imageUrl} alt="Without background" style={{ maxWidth: '100%', height: 'auto' }} />
                    <br />
                    <a href={imageUrl} download="bg-removed.png">
                        {/* <button>Download Image</button> */}
                        <div className="flex items-center justify-start mt-4 col-span-2">

                    <PrimaryButton className="ms-4" >
                        Download Image
                    </PrimaryButton>

                </div>
                    </a>
                </div>
            )}
        </Feature>
    )
}
