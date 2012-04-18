#! /bin/bash
rsync -clrtuvz --exclude="dataset" /home/khuang/Workspace/benchmark/ khuang@stardance.cse.ucsc.edu:/soe/khuang/.html/research/benchmark/
