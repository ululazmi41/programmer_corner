<x-layout>
    <div class="flex md:gap-8 pt-8 md:pt-16">
        <x-left />
        <div class="lg:w-3/5 sm:pr-2 lg:pr-0">
            <div class="flex flex-col">
                <x-card
                author="Python"
                date="1/12/2024"
                imageUrl="python.png"
                title="What's the cheapest way to host a python script?"
                description="Hello, I have a Python script that I need to run every minute. I came across PythonAnywhere, which costs about $5 per month for the first Tier Account. Are there any cheaper alternatives to keep my script running? Would it be more cost-effective to run the script continuously by leaving my computer on? I’m new to this, so any advice or suggestions would be greatly appreciated. Thank you! "
                likes="13"
                comments="21"
                views="1.2K"
                :liked="true"
                :featured="true"
                :bookmark="true" />
            <x-card
                author="Golang"
                date="3/12/2024"
                imageUrl="go.png"
                title="Advent of Code 2024 Day 1: Missing abs() for integers"
                description="Wrote a blog about this year's advent of code day 1. While solving the problem I was once again struck with the
missing function for calculating absolute value for integers and decided to dig a lil deeper. You'll also find a small
recap of how the abs() function for floats evolved over time in the standard library. "
                likes="7"
                comments="3"
                views="419"
                :liked="false"
                :featured="false"
                :bookmark="false" />
            </div>
        </div>
        <x-right />
    </div>
</x-layout>