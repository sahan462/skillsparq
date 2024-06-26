    <div class="job-card" job-url="displayJob&jobId=<?php echo $job['job_id']?>&amp;buyerId=<?php echo $job['buyer_id']?>" <?php if ($_SESSION['role'] === 'Buyer') { echo ($data['mode'] !== 'private') ? 'style="pointer-events: none;"' : ''; } ?>>
    
        <div class="title">

            <?php echo $job['title']?>

            <div class="links">

                <?php
                    if($_SESSION['role'] === "Buyer"){
                        
                        if(($data['mode'] == 'private') && ($job['ongoing_order_count']) == 0){ ?>
                            <!-- edit and delete will be accessible -->
                            <a href="updateJob&amp;userId=<?php echo $job['buyer_id']?>&amp;jobId=<?php echo $job['job_id']?>&amp;publishMode=<?php echo $job['publish_mode']?>">edit</a>
                            <a href="job/deleteJob&amp;userId=<?php echo $job['buyer_id']?>&amp;jobId=<?php echo $job['job_id']?>&amp;publishMode=<?php echo $job['publish_mode']?>">delete</a>
                <?php } 
                    }else{
                        // view only
                    }
                ?>

            </div>

        </div>

        <div class="description">

            <p>
                <?php echo $job['description']?>
            </p>

        </div>

        <div class="job-data">

            <div class="job-data-basic">

                <div class="category">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3" />
                    </svg>
                    <?php echo $job['category']?>

                </div>
                
                <div class="price">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                    <?php echo $job['amount']?>

                </div>

                <div class="flexibility">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    <?php if($job['flexible_amount'] == 1){
                                echo "Negotiable";
                            }else{
                                echo "Fixed Price";
                    }?>

                </div>

                <div class="flexibility">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                    On or Before
                    <?php echo $job['deadline']?>

                </div>
                
                <?php if($_SESSION['role'] === "Seller" && $job['publish_mode'] === "Auction Mode"){?>

                    <div class="auction">

                        <svg height="200px" width="200px" version="1.1" id="_x34_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path style="fill:#6D453D;" d="M362.724,258.882l-50.044,50.045l-5.591-5.921L210.78,201.06 c-3.675-3.675-3.378-9.982,0.657-14.017l29.407-29.407c4.035-4.035,10.342-4.332,14.017-0.657l101.941,96.312L362.724,258.882z"></path> <path style="fill:#845245;" d="M501.549,390.544c0.119,0.119,0.246,0.229,0.369,0.352c14.386,14.386,13.241,38.859-2.56,54.66 c-15.801,15.801-40.275,16.946-54.66,2.56c-0.123-0.123-0.233-0.25-0.352-0.369c-0.653-0.373-1.263-0.822-1.814-1.373 L314.976,311.36l-2.297-2.433l50.044-50.045l2.433,2.297l135.019,127.55C500.726,389.281,501.171,389.896,501.549,390.544z"></path> <path style="fill:#EAC16D;" d="M270.393,136.571l-80.022,80.022c-2.52,2.52-6.604,2.52-9.124,0l-66.53-66.53 c-2.519-2.52-2.519-6.604,0-9.124l80.022-80.022c2.52-2.52,6.604-2.52,9.124,0l66.53,66.53 C272.912,129.966,272.912,134.051,270.393,136.571z"></path> <polygon style="fill:#EAC16D;" points="365.157,261.18 314.976,311.36 312.679,308.927 307.089,303.006 356.802,253.292 362.724,258.882 "></polygon> <g> <g> <path style="fill:#6D453D;" d="M143.058,244.467c2.44-17.092,15.937-30.589,33.032-33.032l-51.598-51.598 c-2.443,17.095-15.94,30.592-33.032,33.032L143.058,244.467z"></path> <path style="fill:#845245;" d="M58.605,191.95l16.378-16.378c1.59-1.59,4.167-1.59,5.757,0l74.997,74.997 c1.59,1.59,1.59,4.167,0,5.757l-16.378,16.378c-6.613,6.613-17.334,6.613-23.946,0l-56.808-56.808 C51.992,209.284,51.992,198.563,58.605,191.95z"></path> <path style="fill:#845245;" d="M162.258,249.806l-16.378,16.378c-1.59,1.59-4.167,1.59-5.757,0l-74.997-74.997 c-1.59-1.59-1.59-4.167,0-5.757l16.378-16.378c6.613-6.613,17.334-6.613,23.946,0l56.808,56.808 C168.87,232.472,168.87,243.193,162.258,249.806z"></path> <path style="fill:#BC9381;" d="M151.466,260.597L151.466,260.597c1.024-1.024,1.024-2.685,0-3.71l-77.045-77.045 c-1.024-1.024-2.685-1.024-3.709,0h0c-1.866,1.866-1.866,4.892,0,6.758l73.997,73.997 C146.574,262.463,149.6,262.463,151.466,260.597z"></path> </g> <path style="fill:#845245;" d="M108.924,141.631l0.897-0.897c0.842-0.842,2.208-0.842,3.05,0l77.704,77.704 c0.842,0.842,0.842,2.208,0,3.05l-0.897,0.897c-3.503,3.503-9.183,3.503-12.687,0l-68.068-68.068 C105.42,150.814,105.42,145.134,108.924,141.631z"></path> </g> <g> <g> <path style="fill:#6D453D;" d="M246.515,37.815c-2.44,17.092-15.937,30.588-33.032,33.031l51.598,51.598 c2.443-17.095,15.94-30.592,33.031-33.032L246.515,37.815z"></path> <path style="fill:#845245;" d="M245.595,4.959l-16.378,16.378c-1.59,1.59-1.59,4.167,0,5.757l74.997,74.997 c1.59,1.59,4.167,1.59,5.757,0l16.378-16.378c6.613-6.613,6.613-17.334,0-23.946L269.542,4.959 C262.929-1.653,252.208-1.653,245.595,4.959z"></path> <path style="fill:#845245;" d="M303.451,108.612l16.378-16.378c1.59-1.59,1.59-4.167,0-5.757L244.832,11.48 c-1.59-1.59-4.167-1.59-5.757,0l-16.378,16.378c-6.613,6.613-6.613,17.334,0,23.947l56.808,56.808 C286.117,115.225,296.839,115.225,303.451,108.612z"></path> <path style="fill:#BC9381;" d="M314.243,97.821L314.243,97.821c-1.024,1.024-2.685,1.024-3.709,0l-77.045-77.045 c-1.024-1.024-1.024-2.685,0-3.71l0,0c1.866-1.866,4.892-1.866,6.758,0l73.997,73.997 C316.109,92.929,316.109,95.955,314.243,97.821z"></path> </g> <path style="fill:#845245;" d="M195.276,55.278l-0.897,0.897c-0.842,0.842-0.842,2.208,0,3.05l77.704,77.704 c0.842,0.842,2.208,0.842,3.05,0l0.897-0.897c3.503-3.503,3.503-9.183,0-12.687l-68.068-68.068 C204.46,51.775,198.78,51.775,195.276,55.278z"></path> </g> </g> <path style="opacity:0.06;fill:#040000;" d="M245.595,4.96l-6.52,6.52l-9.858,9.858l-6.52,6.52 c-6.613,6.613-6.613,17.334,0,23.947l10.302,10.302c-3.39,2.85-7.273,5.132-11.505,6.702l-13.53-13.53 c-3.503-3.503-9.183-3.504-12.687,0l-0.897,0.897c-0.842,0.842-0.842,2.208,0,3.05l1.079,1.079 c-0.25,0.186-0.493,0.385-0.72,0.612l-40.01,40.011l344.629,344.629c15.801-15.801,16.946-40.275,2.56-54.66 c-0.123-0.123-0.25-0.233-0.369-0.352c-0.377-0.648-0.822-1.263-1.373-1.814L365.156,261.18l-2.433-2.297l-5.921-5.591 L254.861,156.98c-0.861-0.861-1.869-1.495-2.955-1.923l18.486-18.486c0.227-0.227,0.426-0.47,0.611-0.72l1.079,1.079 c0.842,0.842,2.208,0.842,3.05,0l0.897-0.897c3.503-3.503,3.503-9.183,0-12.687l-8.912-8.912c1.57-4.232,3.852-8.115,6.702-11.505 l5.684,5.684c6.613,6.613,17.334,6.613,23.946,0l6.52-6.52l9.858-9.858l6.52-6.52c6.613-6.613,6.613-17.334,0-23.946 L269.542,4.959C262.929-1.653,252.208-1.653,245.595,4.96z"></path> </g> <g> <path style="fill:#E9754E;" d="M205.817,355.779v77.35c0,10.22-8.354,18.499-18.498,18.499H51.264 c-10.144,0-18.499-8.279-18.499-18.499v-77.35c0-10.145,8.354-18.499,18.499-18.499h136.055c2.312,0,4.625,0.447,6.638,1.268 c4.849,1.865,8.728,5.744,10.592,10.591C205.37,351.153,205.817,353.466,205.817,355.779z"></path> <path style="fill:#845245;" d="M17.146,383.877H221.43c9.429,0,17.143,7.714,17.143,17.143v50.597c0,3.62-2.961,6.581-6.581,6.581 H6.581c-3.62,0-6.581-2.961-6.581-6.581v-50.595C0,391.593,7.716,383.877,17.146,383.877z"></path> <path style="opacity:0.1;fill:#040000;" d="M238.563,401.055v50.572c0,3.58-2.984,6.565-6.564,6.565H119.292V337.279h68.027 c2.312,0,4.625,0.447,6.638,1.268c4.849,1.865,8.728,5.744,10.592,10.591c0.82,2.014,1.268,4.327,1.268,6.64v28.12h15.589 C230.88,383.899,238.563,391.582,238.563,401.055z"></path> </g> </g> </g></svg>
                        Auction Job

                    </div>

                <?php }if($_SESSION['role'] === "Seller" && $job['publish_mode'] === "Standard Mode"){?>

                    <div class="auction">

                        <svg fill="#000000" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M93.8,114.6c-4.7,1.1-1.7,0.9-5.6,1.4C71.5,119.6,83.9,122.8,93.8,114.6z M387.5,121.3c1.2-0.8,5.4-4.9-7.7-8.9 c0.8,4.1-2.7,3.7-2.7,6c9.7,8.8,13.7,24.1,26.1,27.3C405.6,134.7,392.2,129.3,387.5,121.3z M84.9,111.4c1.5,8.9,8.2-9.4,8.3-15.9 c-2.6,1.5-5.2,3-7.9,4.2c6.3,3.2,0.8,6.6-6,11.7C65.5,128.6,92.2,98,84.9,111.4z M256,0C114.6,0,0,114.6,0,256 c0,141.3,114.6,256,256,256c141.4,0,256-114.7,256-256C512,114.6,397.4,0,256,0z M262.8,85.8l1.2,0.4c-4.8,6.2,25,24.3,3.6,25.8 c-20,5.7,8.4-5.2-7.1-3.3C268.7,97.3,254,97.1,262.8,85.8z M141.4,102.2c-7.2-6-29.8,8.2-21.9,4.8c19.6-7.7,1.3,0.8,5.9,10 c-4.2,8.7-1.4-8.6-11.8,1.7c-7.5,1.7-25.9,18.7-23.6,13.5c-0.6,8.1-21.9,17.7-24.8,31.2c-7,18.7-1.7-0.7-3-8 c-10-12.7-28.2,21.5-22.8,35c9.1-16,8.4-1.7,1.8,5.4c6.7,12.3-6.1,28.3,6.6,37.4c5.6,1.3,16.8-18.8,11.9,2.1 c3.4-18.1,9.4,4.3,19.1-0.7c0.6,9.5,6.5,5.1,7.8,16.6c16.2-1.2,31,26.2,11.7,31.4c2.9-0.8,8.6,4.3,15.2,0.4 c11.2,8.9,40.7,10,41.5,32c-20.3,9.7-5,36.3-22.6,45.8c-20.2-3-6.9,24.9-15.4,21.7c3.4,20.1-20.4-2.6-11.2,8.5 c16.9,10.4-7.4,8.3,0.2,15.9c-8.5-1.8,5.3,15.8,7.6,22.3c12.2,19.8-10.5-4.4-17.2-11c-6.4-12.8-21.5-37.3-25.7-57.4 c-2.4-29.2-25-48.8-30.2-77.3c-5.2-15.9,14.3-41.4,3.8-50.3c-9.1-7.1-5.4-31.4-10.8-44.2c13.5-58.5,56.4-107.8,107.9-137 c-5.3,3.9,30.3-10.1,26.2-6.7c-1.1,2.5,20.8-9.5,34-11.3c-1.4,0.2-34.3,12-25.2,10.4c-14.1,6.9-1.4,3,5.6-0.5 c-14,10.3-24.8,7.4-40.7,16.5c-16,4.2-12.7,20.8-24.1,29.1c6.7,1.2,23.5-17.3,33.3-23.8c22.5-10.9-11.4,19.8,10,6.6 c-7.2,6.7-5.7,17.4-10.1,20.4C148.2,92.1,159.1,97.9,141.4,102.2z M176.4,56.2c-2.3,3.1-5.5,9.8-7.4,5.7c-2.6,1.3-3.6,6.9-8.5,2.4 c2.9-2.1,5.9-7.1,0.2-4c2.6-2.8,25.8-10.7,24.5-13.7c4.1-2.6,3.7-3.9-1-2.3c-2.4-0.8,5.7-7.6,16.5-8.5c1.5,0,2.1,1-0.6,0.7 c-16.3,5-9.3,3.6,1.7,0c-4.2,2.4-7.1,3.1-7.8,4.2c11-4-0.6,2.9,1.9,2.4c-3.1,1.6,0.5,2.1-5.5,4.4c1.1-0.9-9.8,6.5-3.3,4.3 C180.8,57.8,178,57.9,176.4,56.2z M186,70.5c0.2-9.6,14-15.7,12.3-16.2c17-8-5.9,0.3,7.5-6.9c5-0.5,15.6-16.5,30.3-17.5 c16.2-4.9,8.7,0.3,20.7-4.3l-2.4,2c-2.1,0.3,0.5,4-7.1,9.6c-0.8,8.7-14.5,4.7-7.7,14c-4.4-6.3-11-0.2-2.7,0.4 c-8.9,6.8-29.6,8-39.5,19.3C191,80.1,185.1,77.2,186,70.5z M257.1,102.5c-6.8,16.4-13.4-2.4-1.4-5.4 C258.7,98.7,259.9,99.2,257.1,102.5z M231.5,69.7c-2-7.4-0.4-3.5,11.5-7C251.2,68.6,235.7,72.5,231.5,69.7z M417.7,363.2 c-9.4-16.2,11.4-31.2,18.4-44.8C435.2,334.3,433.2,350,417.7,363.2z M453.1,178.1c-10.2,0.8-19.4,3.2-28.6-2.6 c-21.2-23.2,3.9,26.2,10.9,6c25.2,9.6-0.4,51-16.3,46.7c-8.9-19.2-19.9-40.3-39.3-49.7c14.9,16.5,22.3,36.8,38.3,51.7 c1.1,20.8,22.2-7.6,20.9,8.5c2,27.7-31.3,44.3-25.5,72.1c12.4,25.3-23.9,29.9-19.8,52.6c-14.6,16.3-30.2,38.3-56.4,34.8 c0-13.8-7-25.5-8.6-39.7c-14.2-18,15-37.3-3.1-56.1c-20.9-4.7,4.3-33.5-17.2-30.8c-12.9-12.9-31.8-0.4-50.3-0.3 c-23.2,2.2-47.1-28.5-36.8-50.2c-8.2-22.6,26-29.2,26.9-49.1c16.4-13.7,39.7-12,61.9-15.2c-1.6,15.9,15.2,16,27.9,21.3 c7.1-17.2,29.2,2.8,44.3-8.1c5.2-25.4-14.7-10.1-26.1-18.2c-13.8-20.2,29.5-10.4,25-21c-16.8-0.1-7.3-20.7-19.2-9.2 c10.7,1.9-1.9,10.3-1.6,0.7c-16.2-4.7-0.6,18.4-8.8,20.6c-12.5-5.2-6.6,5.9-5.3,7.6c-5.4,11.7-12-17.2-27.3-16.4 c-15.2-13.9-6,6.3,7.2,9.6c-2.8,0.8,1.6,12.3-1.9,7.4c-10.9-15-31.6-25-43.9-6.6c-1.3,17.2-36.3,22.1-30.7,2 c-8.2-20.8,25.4-0.6,22.3-17.2c-21.6-14.3,5.9-9.7,13.2-23.1c16.6,0.5,0.7-13.6,8.5-17.7c-0.8,15.3,12.7,12.4,23.4,9.5 c-2.6-8.8,6.4-8.5,0.9-15.8c24.8-9.9-18.9,4.6-10.1-17.1c-10.7-7.4-4.5,16.3,0,18.8c0.3,7.3-5.9,16.3-14.4,1 c-12.4,8.1-11.1-8.2-11.9-6.5c-1.4-6.3,9.4-6.6,9.5-17.6c-0.9-7-0.7-10.7,4.3-11.1c0.4,1,20.5,1.3,27.6,9.6 c-19.4-3.9-2.9,3.2,5.8,7.2c-9.3-7.3,3.7,0-3.9-8.3c3,0.6-8.3-11.4,3.3-0.9c-6.3-7.5,12.3-5.3,1.3-10.9c16.1,4.5,6.6,0.4-2.9-3.7 c-26.2-15.6,46.3,21.1,16.7,4.8c18.9,4.1-40.4-14.6-13.4-6.4c-10.3-4.5-0.3-2,9,0.9c-16.7-5.2-41.7-14.9-40.7-15.3 c5.8,0.4,11.5,1.7,17,3.3c17.1,5.1-4.9-1.2-0.2-1.1C373.8,44,425.3,83.4,456.6,134.9c7.3,7.7,27.2,58.6,16.8,36 c4.7,18,5.4,37.4,7.9,55.8c-5.2-5.8-11-27.2-16-39.1C463.2,192.2,460.8,181.1,453.1,178.1z"></path> </g></svg>
                        Standard Job

                    </div>

                <?php }?>

            </div>  
            
            <?php if($_SESSION['role'] === "Seller"){?>
                <!-- View only -->
            <?php }else if($_SESSION['role'] === "Buyer"){?>

                <div class="job-data-auction" hidden>

                    <?php if($job['publish_mode'] == "Auction Mode"){?>

                        <div class="start">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                            </svg>
                            From - 
                            <?php echo $job['start_time']?>

                        </div>

                        <div class="end">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" />
                            </svg>
                            To - 
                            <?php echo $job['end_time']?>

                        </div>

                        <div class="min-bid">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Min. Bid -
                            <?php echo $job['min_bid_amount']?>

                        </div>
                        
                        <div class="current-highest">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                            </svg>
                            Current Bid - 
                            <?php echo $job['current_highest_bid']?>

                        </div>

                    <?php }?>

                </div>

            <?php }?>

        </div>
        
    </div>